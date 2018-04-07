<?php
declare(strict_types=1);

namespace RouteCMS\Style;

use MatthiasMullie\Minify\CSS;
use RouteCMS\Util\StringUtil;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class SCSSAdminMinifyFile extends MinifyFile
{

	/**
	 * @var string
	 */
	const PATH = GLOBAL_DIR . "/admin/style/";

	/**
	 * @inheritdoc
	 */
	protected $contentType = "text/css";

	/**
	 * @inheritdoc
	 */
	protected function doMinifyFile(): string
	{
		$minifier = new CSS($this->in);

		return $minifier->minify($this->out);
	}

	/**
	 * @inheritdoc
	 */
	protected function loadFile(string $file): void
	{
		if (!StringUtil::endsWith($file, ".css")) {
			//Don´t
			return;
		}
		if (file_exists(self::PATH . $file)) {
			$this->in = self::PATH . $file;
			$this->out = self::PATH . str_replace(".css", ".min.css", $file);
		} elseif (file_exists(self::PATH . "scss/" . str_replace(".css", ".scss", $file))) {
			$this->source = self::PATH . "scss/" . str_replace(".css", ".scss", $file);
			$this->sourceOut = self::PATH . $file;
			$this->in = $this->sourceOut;
			$this->out = str_replace(".css", ".min.css", $this->sourceOut);
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function doCompileSource(): void
	{
		if (empty($this->sourceOut) || empty($this->source)) return;

		$compiler = new StyleCompiler($this->source, $this->sourceOut, self::PATH);
		if ($compiler->needsCompile()) {
			$compiler->compileStyle();
		}
	}
}