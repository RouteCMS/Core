<?php
declare(strict_types=1);

namespace RouteCMS\Compiler;

use RouteCMS\Util\StringUtil;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class RequireJsHelper
{

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var string
	 */
	protected $out;

	/**
	 * RequireJsHelper constructor.
	 *
	 * @param string $path
	 * @param string $out
	 */
	public function __construct(string $path, string $out)
	{
		$this->path = $path;
		$this->out = $out;
	}

	/**
	 * Compile the js files to only one
	 */
	public function compile()
	{
		if (!$this->needsCompile()) return; //file already created, then don´t compile
		$content = "";
		$files = [];
		$start = microtime(true);
		foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path)) as $filename) {
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
	 * Check if this file don´t need to compile again
	 *
	 * @return bool
	 */
	protected function needsCompile(): bool
	{
		if (!is_file($this->out)) {
			return true;
		}

		$mtime = filemtime($this->out);

		$metadataName = $this->metadataName();

		if (is_readable($metadataName)) {
			$metadata = unserialize(file_get_contents($metadataName));

			foreach ($metadata['imports'] as $import => $originalMtime) {
				if (!file_exists($import)) return true;
				
				$currentMtime = filemtime($import);

				if ($currentMtime !== $originalMtime || $currentMtime > $mtime) {
					return true;
				}
			}

			return false;
		}

		return true;
	}

	/**
	 * Get path to meta data
	 *
	 * @return string
	 */
	protected function metadataName(): string
	{
		return $this->out . '.meta';
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
		$path = mb_substr($filename->getRealPath(), mb_strlen($this->path));

		return str_replace(".js", "", $path);
	}
}