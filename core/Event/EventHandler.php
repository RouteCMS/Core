<?php
declare(strict_types=1);

namespace RouteCMS\Event;

use RouteCMS\Cache\EventCache;
use RouteCMS\Core\Singleton;
use RouteCMS\Event\Events\EventListener;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class EventHandler
{

	use Singleton;

	/**
	 * @var EventListener[]
	 */
	private $cache = [];

	/**
	 * @param string $name
	 * @param mixed  $object
	 * @param array  $parameters
	 */
	public function call(string $name, $object, array &$parameters = []): void
	{
		$prefix = get_class($object) . "@" . $name;
		foreach (EventCache::instance()->getEvents($prefix) as $event) {
			$index = $prefix . "@" . $event["class"];
			if (!isset($this->cache[$index])) $this->cache[$index] = new $event["class"];
			
			$this->cache[$index]->fire($name, $object, $parameters);
		}
	}
}