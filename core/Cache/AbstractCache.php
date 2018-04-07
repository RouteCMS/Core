<?php
declare(strict_types=1);

namespace RouteCMS\Cache;

use Phpfastcache\Core\Item\ExtendedCacheItemInterface;
use RouteCMS\Core\RouteCMS;
use RouteCMS\Core\Singleton;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
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
	abstract protected function updateCache(): void;

	/**
	 * @inheritDoc
	 */
	protected function init(): void
	{
		$name = explode('\\', get_class($this));
		$this->cacheItem = RouteCMS::instance()->getCache()->getItem(array_pop($name));
	}
}