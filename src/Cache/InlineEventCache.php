<?php
declare(strict_types=1);

namespace RouteCMS\Cache;

use RouteCMS\Annotations\Event\TemplateEvent;
use RouteCMS\Core\AnnotationHandler;
use RouteCMS\Core\RouteCMS;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class InlineEventCache extends AbstractCache
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
		if (($this->events = $this->getCache()) === null) {
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
		AnnotationHandler::instance()->doCall(TemplateEvent::class, GLOBAL_DIR . "src/Events", function ($className, $item) {
			/** @var TemplateEvent $item */
			if (!isset($this->events[$item->name])) $this->events[$item->name] = [];

			$this->events[$item->name][] = ["class" => $className, "priority" => $item->priority];
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

	/**
	 * @inheritdoc
	 */
	protected function init(): void
	{
		parent::init();
		$this->events = $this->getCache();
	}
}