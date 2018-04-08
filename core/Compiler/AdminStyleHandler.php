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
		//only minify require.js and and dev mode compile the other js files
		$compiler = new JavaScriptMinifyFile(GLOBAL_DIR."admin/js/require.js");
		$compiler->minifyFile();
		
		if(!DEV_MODE){
			$helper = new RequireJsHelper(GLOBAL_DIR."admin/js/require/", GLOBAL_DIR."admin/js/combined.js");
			$helper->compile();
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
	 * @return string[]
	 */
	public function getStyle(): array
	{
		return $this->style;
	}
}