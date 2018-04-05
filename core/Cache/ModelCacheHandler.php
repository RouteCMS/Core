<?php

namespace RouteCMS\Cache;

use Phpfastcache\Core\Item\ExtendedCacheItemInterface;
use Phramz\Doctrine\Annotation\Scanner\ClassInspector;
use RouteCMS\Annotation\AnnotationHandler;
use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Core;
use RouteCMS\Singleton;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
 */
class ModelCacheHandler
{

	use Singleton;

	/**
	 * @var ExtendedCacheItemInterface[]
	 */
	private $cache = [];

	/**
	 * @param string $class
	 *
	 * @return null|ExtendedCacheItemInterface
	 */
	public function getCache($class)
	{
		$name = $this->formatClassName($class);
		if (isset($this->cache[$name])) {
			return $this->cache[$name];
		}

		return null;
	}

	/**
	 * @param string $class
	 *
	 * @return string
	 */
	private function formatClassName($class)
	{
		return str_replace("\\", '-', $class);
	}

	/**
	 * @param string $class
	 */
	public function updateCacheItem($class)
	{
		AnnotationHandler::instance()->getAnnotation($class, ModelCache::class, function ($annotation) use ($class) {
			/** @var ModelCache $annotation */
			$name = $this->formatClassName($class);
			$this->cache[$name] = $this->loadItems($name);
			$this->cache[$name]->expiresAfter($annotation->time);
		});
	}

	/**
	 * Return a list of all items for this items
	 *
	 * @param string $class
	 *
	 * @return array
	 */
	private function loadItems($class)
	{
		return getDatabase()->getRepository($class)->findAll();
	}

	/**
	 * @inheritdoc
	 */
	protected function updateCache()
	{
		foreach ($this->cache as $cacheItem) {
			Core::instance()->getCache()->save($cacheItem);
		}
	}

	/**
	 * @inheritDoc
	 */
	protected function init()
	{
		AnnotationHandler::instance()->doCall(ModelCache::class, GLOBAL_DIR . "model", function ($classInspector, $annotation) {
			/** @var ClassInspector $classInspector */
			if ($annotation instanceof ModelCache) {
				$name = $this->formatClassName($classInspector->getClassName());
				$this->cache[$name] = Core::instance()->getCache()->getItem($name);
			}
		});
	}
}