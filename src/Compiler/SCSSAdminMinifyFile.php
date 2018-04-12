<?php
declare(strict_types=1);

namespace RouteCMS\Compiler;

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
		if (!StringUtil::endsWith($file, ".scss")) {
			//Don´t compile other files
			return;
		}
		$css = str_replace(".scss", ".min.css", $file);
		if (file_exists(self::PATH . $css)) {
			$this->in = self::PATH . "scss/" . $file;
			$this->out = self::PATH . $css;
		} elseif (file_exists(self::PATH . "scss/" .  $file)) {
			$this->source = self::PATH . "scss/" . $file;
			$this->sourceOut = self::PATH . str_replace(".scss", ".css", $file);
			$this->in = $this->sourceOut;
			$this->out = self::PATH . $css;
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function doCompileSource(): void
	{
		if (empty($this->sourceOut) || empty($this->source)) return;

		$compiler = new StyleCompiler($this->source, $this->sourceOut, self::PATH."scss/");
		if ($compiler->needsCompile()) {
			$compiler->compileFile();
		}
	}
}