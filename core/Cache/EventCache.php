<?php

namespace RouteCMS\Cache;

use Phramz\Doctrine\Annotation\Scanner\ClassInspector;
use RouteCMS\Annotations\AnnotationHandler;
use RouteCMS\Annotations\Event;
use RouteCMS\Annotations\Events;
use RouteCMS\Core\RouteCMS;


/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class EventCache extends AbstractCache
{

	/**
	 * @inheritdoc
	 */
	protected $maxLifetime = 60 * 60 * 6;

	/**
	 * @var array
	 */
	protected $events = [];

	/**
	 * @param string $name
	 *
	 * @return array
	 */
	public function getEvents(string $name)
	{
		if (($this->events = $this->getCache()) == null) {
			$this->updateCache();
		}

		return isset($this->events[$name]) ? $this->events[$name] : [];
	}

	/**
	 * @inheritdoc
	 */
	protected function updateCache(): void
	{
		$this->events = [];
		AnnotationHandler::instance()->doCall(Events::class, GLOBAL_DIR . "core/Event/Events", function ($classInspector, $item) {
			/** @var ClassInspector $classInspector */
			/** @var Events $item */
			foreach ($item->events as $event) {
				/** @var Event $event */
				$identifier = $event->getIdentifier();
				if (!isset($this->events[$identifier])) $this->events[$identifier] = [];

				$this->events[$identifier][] = ["class" => $classInspector->getClassName(), "priority" => $event->priority];
			}
		});
		//sort events by priority
		foreach ($this->events as &$itemList) {
			usort($itemList, function ($a, $b) {
				if ($a["priority"] == $b["priority"]) {
					return 0;
				}

				return ($a["priority"] < $b["priority"]) ? -1 : 1;
			});
		}
		$this->cacheItem->set($this->events)->expiresAfter($this->maxLifetime);

		RouteCMS::instance()->getCache()->save($this->cacheItem);
	}

}