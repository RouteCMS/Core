<?php
declare(strict_types=1);

namespace RouteCMS\Plugin;

use Phramz\Doctrine\Annotation\Scanner\FileInspector;
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
			GLOBAL_DIR . "src/Events",
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
	 * List of active plugins
	 *
	 * @var array
	 */
	protected $plugins = [

	];

	/**
	 * List of active plugins
	 *
	 * @var Plugin[]
	 */
	protected $pluginsLoaded = [

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
	public function loadEnabledPlugins(): void
	{
		if ($this->enable) return; //Don´t load plugins twice
		$this->enable = true;
		foreach ($this->plugins as $path => $plugin) {
			$file = $path . "/" . $plugin["package"]["class"];
			$main = new FileInspector($file);
			/** @noinspection PhpIncludeInspection */
			require_once $file;
			$class = $main->getFullQualifiedClassname();
			$this->pluginsLoaded[$path] = new $class($path);
		}
	}

	/**
	 * @inheritDoc
	 */
	protected function init(): void
	{
		foreach (glob(GLOBAL_DIR . "public/extension/*/plugin.json") as $file) {
			$this->plugins[dirname($file)] = json_decode(file_get_contents($file), true);
		}
	}
}