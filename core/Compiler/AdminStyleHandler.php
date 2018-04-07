<?php
declare(strict_types=1);

namespace RouteCMS\Compiler;

use RouteCMS\Core\Singleton;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class AdminStyleHandler
{

	use Singleton;

	/**
	 * List of style files to compile
	 *
	 * @var string[]
	 */
	protected $style = [
		"core.scss",
		"font-awesome.scss"
	];

	/**
	 * List of javascript files to minify
	 *
	 * @var string[]
	 */
	protected $script = [
		"jquery.js",
		"popper.js",
		"bootstrap.js"
	];

	/**
	 * Compile all style files, if it need and minifiy them
	 */
	public function compile(): void
	{
		array_unique($this->style); //don´t compile the same files twice
		global $event;
		foreach ($this->style as $file) {
			$compiler = new SCSSAdminMinifyFile($file);
			$compiler->minifyFile();
		}
		foreach ($this->script as $file) {
			$compiler = new JavaScriptAdminMinifyFile($file);
			$compiler->minifyFile();
		}
		$event->call("compile", $this, $this->style);
	}

	/**
	 * Delete all compiled and minifed files
	 */
	public function clearCache(): void
	{
		//delete style files
		foreach ($this->style as $file) {
			$file = SCSSAdminMinifyFile::PATH . str_replace(".scss", ".css", $file);
			$fileMin = SCSSAdminMinifyFile::PATH . str_replace(".scss", ".min.css", $file);
			$fileMeta = SCSSAdminMinifyFile::PATH . str_replace(".scss", ".css.meta", $file);
			if (file_exists($file)) @unlink($file);
			if (file_exists($fileMin)) @unlink($fileMin);
			if (file_exists($fileMeta)) @unlink($fileMeta);
		}
		foreach ($this->script as $file) {
			$file = JavaScriptAdminMinifyFile::PATH . str_replace(".js", ".min.jss", $file);
			if (file_exists($file)) @unlink($file);
		}
	}

	/**
	 * Add a style file witch should compile
	 *
	 * @param string $file
	 */
	public function addStyle(string $file): void
	{
		$this->style[] = $file;
	}

	/**
	 * Add a javascript file witch should compile
	 *
	 * @param string $file
	 */
	public function addScript(string $file): void
	{
		$this->style[] = $file;
	}

	/**
	 * @return string[]
	 */
	public function getStyle(): array
	{
		return $this->style;
	}

	/**
	 * @return string[]
	 */
	public function getScript(): array
	{
		return $this->script;
	}
}