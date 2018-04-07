<?php
declare(strict_types=1);

namespace RouteCMS\Style;

use RouteCMS\Core\Singleton;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class StyleHandler
{

	use Singleton;

	/**
	 * List of style files to compile
	 *
	 * @var string[]
	 */
	protected $style = [
		"core.css",
		"font-awesome.css"
	];

	/**
	 * Compile all style files, if it need and minifiy them
	 *
	 * @param bool $admin
	 */
	public function compile(bool $admin = false): void
	{
		array_unique($this->style); //don´t compile the same files twice
		global $event;
		if ($admin) {
			foreach ($this->style as $file) {
				$compiler = new SCSSAdminMinifyFile($file);
				$compiler->minifyFile();
			}
			$event->call("adminCompile", $this, $this->style);
		} else {
			$event->call("frontendCompile", $this);
			//TODO compile frontend styles
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
}