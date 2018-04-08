<?php
declare(strict_types=1);

namespace RouteCMS\Compiler;

use RouteCMS\Util\StringUtil;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class RequireJsHelper extends AbstractFileCompiler
{

	/**
	 * Compile the current file
	 */
	public function compileFile(): void
	{
		$content = "";
		$files = [];
		$start = microtime(true);
		foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->in)) as $filename) {
			/** @var \SplFileInfo $filename */
			if (!$filename->isFile()) continue;
			if (!StringUtil::endsWith($filename->getFilename(), "js") || StringUtil::endsWith($filename->getFilename(), "min.js")) continue;

			$content .= $this->getContent($filename);
			$content .= "\n";
			$files[$filename->getRealPath()] = $filename->getMTime();
		}
		$elapsed = round((microtime(true) - $start), 4);
		$t = date('r');
		$content = "/* JavaScript compiled on $t (${elapsed}s) */\n\n" . $content;
		$etag = md5($content);
		file_put_contents($this->out, $content);
		file_put_contents(
			$this->metadataName(),
			serialize([
				'etag'    => $etag,
				'imports' => $files
			])
		);
		$compiler = new JavaScriptMinifyFile($this->out);
		$compiler->minifyFile();
	}

	/**
	 * @param \SplFileInfo $filename
	 *
	 * @return string
	 */
	protected function &getContent(\SplFileInfo &$filename): string
	{
		$content = file_get_contents($filename->getRealPath());
		if (mb_strpos($content, "define([") !== false) {
			$content = str_replace("define([", "define('" . $this->getNamespace($filename) . "', [", $content);
		}

		return $content;
	}

	/**
	 * @param \SplFileInfo $filename
	 *
	 * @return string
	 */
	protected function getNamespace(\SplFileInfo &$filename): string
	{
		//remove start path
		$path = mb_substr($filename->getRealPath(), mb_strlen($this->in));

		return str_replace(".js", "", $path);
	}
}