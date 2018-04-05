<?php

namespace RouteCMS\Annotations;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Phramz\Doctrine\Annotation\Scanner\ClassInspector;
use Phramz\Doctrine\Annotation\Scanner\FileInspector;
use Phramz\Doctrine\Annotation\Scanner\Finder;
use RouteCMS\Cache\DoctrineCache;
use RouteCMS\Core\Singleton;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @mixin AnnotationReader
 */
class AnnotationHandler
{

	use Singleton;

	/**
	 * @var CachedReader
	 */
	private $reader;

	/**
	 * @param string   $annotation
	 * @param string   $path
	 * @param callable $callback
	 */
	public function doCall($annotation, $path, callable $callback)
	{
		$fileList = $this->getAnnotationsInPath($annotation, $path);
		foreach ($fileList as $file) {
			/** @var SplFileInfo $file */
			$classInspector = $this->getFileInspector($file)->getClassInspector($this->getReader());
			$annotations = $classInspector->getClassAnnotations();
			foreach ($annotations as $item) {
				if (is_a($item, $annotation)) {
					$callback($classInspector, $item);
				}
			}
		}
	}

	/**
	 * @param string $annotation
	 * @param string $path
	 *
	 * @return Finder
	 */
	public function getAnnotationsInPath($annotation, $path): Finder
	{
		$finder = new Finder();
		$finder->containsAtLeastOneOf($annotation)->setReader($this->reader)->in($path);

		return $finder;
	}

	/**
	 * @param SplFileInfo $file
	 *
	 * @return FileInspector
	 */
	public function getFileInspector($file): FileInspector
	{
		return new FileInspector($file->getRealPath());
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
	public function hasAnnotation($class, $annotation)
	{
		$result = false;
		$this->getAnnotation($class, $annotation, function () use (&$result) {
			$result = true;
		});

		return $result;
	}

	/**
	 * @param string   $class
	 * @param string   $annotation
	 * @param callable $callback
	 */
	public function getAnnotation($class, $annotation, callable $callback)
	{
		$classInspector = new ClassInspector($class, $this->getReader());
		$annotations = $classInspector->getClassAnnotations();
		foreach ($annotations as $item) {
			if (is_a($item, $annotation)) {
				$callback($item);
			}
		}
	}

	/**
	 * @param string   $class
	 * @param string   $annotation
	 * @param callable $callback
	 */
	public function getPropertyAnnotation($class, $annotation, callable $callback)
	{
		$classInspector = new ClassInspector($class, $this->getReader());
		foreach ($classInspector->getPropertyAnnotations() as $name => $properties) {
			foreach ($properties as $property) {
				if (is_a($property, $annotation)) {
					$callback($name, $property);
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
	 * @param string $path
	 *
	 * @return FileInspector
	 */
	public function getFileInspectorByPath($path): FileInspector
	{
		return new FileInspector($path);
	}

	/**
	 * @inheritdoc
	 */
	protected function init()
	{
		$this->reader = new CachedReader(new AnnotationReader(), DoctrineCache::instance());
	}

}