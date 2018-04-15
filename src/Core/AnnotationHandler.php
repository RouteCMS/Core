<?php
declare(strict_types=1);

namespace RouteCMS\Core;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use RouteCMS\Cache\AnnotationCache;
use RouteCMS\Cache\DoctrineCache;
use RouteCMS\Plugin\PluginHandler;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @mixin AnnotationReader
 */
class AnnotationHandler
{

	use Singleton;

	const BREAK_LOOP = "break_loop";

	/**
	 * @var CachedReader
	 */
	private $reader;

	/**
	 * @param string   $annotation
	 * @param string   $type
	 * @param callable $callback
	 */
	public function doCall(string $annotation, string $type, $callback): void
	{
		foreach (PluginHandler::instance()->getPath($type) as $path) {
			foreach (AnnotationCache::instance()->getInfoByPath($annotation, $path, $this->getReader()) as $info) {
				$annotations = $info->getClassAnnotations();
				foreach ($annotations as $item) {
					if (is_a($item, $annotation)) {
						if (call_user_func($callback, $info->getClassName(), $item) == self::BREAK_LOOP) {
							break 2;
						}
					}
				}
			}
		}
	}

	/**
	 * @return CachedReader
	 */
	public function getReader(): CachedReader
	{
		return $this->reader;
	}

	/**
	 * @param string $class
	 * @param string $annotation
	 *
	 * @return boolean
	 */
	public function hasAnnotation(string $class, string $annotation): bool
	{
		$result = false;
		$this->getAnnotation($class, $annotation, function () use (&$result) {
			$result = true;

			return self::BREAK_LOOP;
		});

		return $result;
	}

	/**
	 * @param string   $class
	 * @param string   $annotation
	 * @param callable $callback
	 */
	public function getAnnotation(string $class, string $annotation, $callback): void
	{
		$classInfo = AnnotationCache::instance()->getClassInfo($class, $this->getReader());
		foreach ($classInfo->getClassAnnotations() as $item) {
			if (is_a($item, $annotation)) {
				if (call_user_func($callback, $item) === self::BREAK_LOOP) {
					break;
				}
			}
		}
	}

	/**
	 * @param string   $class
	 * @param string   $annotation
	 * @param callable $callback
	 */
	public function getPropertyAnnotation(string $class, string $annotation, $callback): void
	{
		$classInfo = AnnotationCache::instance()->getClassInfo($class, $this->getReader());
		foreach ($classInfo->getPropertyAnnotations() as $name => $properties) {
			foreach ($properties as $property) {
				if (is_a($property, $annotation)) {
					if (call_user_func($callback, $name, $property) === self::BREAK_LOOP) {
						break 2;
					}
				}
			}
		}
	}

	/**
	 * Find an annotations and execute an callback with a list of all annotations for this field/element
	 *
	 * @param string   $class
	 * @param string   $annotation
	 * @param callable $callback
	 */
	public function getPropertyAnnotationWithOther(string $class, string $annotation, $callback): void
	{
		$classInfo = AnnotationCache::instance()->getClassInfo($class, $this->getReader());
		foreach ($classInfo->getPropertyAnnotations() as $name => $properties) {
			foreach ($properties as $property) {
				if (is_a($property, $annotation)) {
					if (call_user_func($callback, $name, $property, $properties) === self::BREAK_LOOP) {
						break 2;
					}
				}
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	public function __call($name, $arguments)
	{
		return call_user_func([$this->reader, $name], $arguments);
	}

	/**
	 * @inheritdoc
	 */
	protected function init(): void
	{
		$this->reader = new CachedReader(new AnnotationReader(), DoctrineCache::instance());
	}

}