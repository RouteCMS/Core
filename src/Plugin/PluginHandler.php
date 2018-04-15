<?php
declare(strict_types=1);

namespace RouteCMS\Plugin;

use RouteCMS\Core\Singleton;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class PluginHandler
{

	use Singleton;

	/**
	 * @var array
	 */
	protected $paths = [
		"events"       => [
			GLOBAL_DIR . "src/Events"
		],
		"inlineEvents" => [
			GLOBAL_DIR . "src/Events"
		],
		"controller"   => [
			GLOBAL_DIR . "src/Controller"
		],
		"enumColumn"   => [
			GLOBAL_DIR . "src/Doctrine"
		]
	];

	/**
	 * Set if the plugins loaded
	 *
	 * @var bool
	 */
	private $enable = false;

	/**
	 * Return the lis of paths by given type
	 *
	 * @param string $type
	 *
	 * @return string[]
	 */
	public function getPath(string $type): array
	{
		return isset($this->paths[$type]) ? $this->paths[$type] : [];
	}

	/**
	 * Register a new load path for php files
	 *
	 * @param string $type
	 * @param string $path
	 */
	public function registerPath(string $type, string $path): void
	{
		if (!isset($this->paths[$type])) $this->paths[$type] = [];
		$this->paths[$type][] = $path;
	}

	/**
	 * Load and enable plugins 
	 */
	public function enablePlugins(): void
	{
		if ($this->enable) return; //Don´t load plugins twice
		$this->enable = true;
		//TODO enable active plugins
	}

	/**
	 * @inheritDoc
	 */
	protected function init(): void
	{
		//TODO read active plugins
	}
}