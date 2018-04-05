<?php

namespace RouteCMS\Cache;

use Phpfastcache\Core\Item\ExtendedCacheItemInterface;
use RouteCMS\Core\RouteCMS;
use RouteCMS\Core\Singleton;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
 */
abstract class AbstractCache
{

	use Singleton;

	/**
	 * maximum cache lifetime in seconds
	 *
	 * @var    integer
	 */
	protected $maxLifetime = 600;

	/**
	 * The cache item
	 *
	 * @var ExtendedCacheItemInterface
	 */
	protected $cacheItem;

	/**
	 * Return the cache content
	 *
	 * @return mixed
	 */
	public function getCache()
	{
		return $this->cacheItem->get();
	}

	/**
	 * Update the cache
	 */
	abstract protected function updateCache();

	/**
	 * @inheritDoc
	 */
	protected function init()
	{
		$name = explode('\\', get_class($this));
		$this->cacheItem = RouteCMS::instance()->getCache()->getItem(array_pop($name));
	}
}