<?php
declare(strict_types=1);

namespace RouteCMS\Core;

use RouteCMS\Cache\EventCache;
use RouteCMS\Cache\InlineEventCache;
use RouteCMS\Events\EventListener;
use RouteCMS\Events\InlineEventListener;


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
	 * @var InlineEventListener[]
	 */
	private $cacheInline = [];

	/**
	 * Call events
	 * 
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

	/**
	 * Call inline events
	 * 
	 * @param string $eventName
	 * @param array  $parameters
	 */
	public function callInline(string $eventName, array &$parameters = []): void
	{
		$prefix = $eventName;
		foreach (InlineEventCache::instance()->getEvents($prefix) as $event) {
			$index = $prefix . "@" . $event["class"];
			if (!isset($this->cacheInline[$index])) $this->cacheInline[$index] = new $event["class"];

			$this->cacheInline[$index]->fire($eventName, $parameters);
		}
	}
}