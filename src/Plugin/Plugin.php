<?php
declare(strict_types=1);

namespace RouteCMS\Plugin;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
interface Plugin
{

	/**
	 * Init plugin(Init paths and any more)
	 *
	 * @param string $path
	 *
	 * @return void
	 */
	public function init(string $path): void;

	/**
	 * Install this plugin
	 * 
	 * @return void
	 */
	public function install(): void;

	/**
	 * Remove this plugin
	 * 
	 * @return void
	 */
	public function uninstall(): void;
}