<?php
declare(strict_types=1);

namespace RouteCMS\Cache;

use Doctrine\Common\Annotations\CachedReader;
use Phramz\Doctrine\Annotation\Scanner\ClassInspector;
use Phramz\Doctrine\Annotation\Scanner\FileInspector;
use Phramz\Doctrine\Annotation\Scanner\Finder;
use RouteCMS\Core\RouteCMS;
use RouteCMS\Doctrine\ClassAnnotation;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class AnnotationCache extends AbstractCache
{

	/**
	 * @var ClassAnnotation[]
	 */
	private $annotations = [];

	/**
	 * @var ClassAnnotation[][]
	 */
	private $finder = [];

	/**
	 * Return an class inspector from cache
	 *
	 * @param string       $class
	 * @param CachedReader $cachedReader
	 *
	 * @return ClassAnnotation
	 */
	public function getClassInfo(string $class, CachedReader $cachedReader):ClassAnnotation
	{
		if (!isset($this->annotations[$class])) {
			$this->createInspector($class, $cachedReader);
			$this->updateCache();
		}

		return $this->annotations[$class];
	}

	/**
	 * Create a class inspector for a class
	 *
	 * @param string       $class
	 * @param CachedReader $cachedReader
	 */
	protected function createInspector(string $class, CachedReader $cachedReader): void
	{
		$classInspector = new ClassInspector($class, $cachedReader);
		$this->annotations[$class] = new ClassAnnotation($classInspector->getClassName(), $classInspector->getClassAnnotations(), $classInspector->getMethodAnnotations(), $classInspector->getPropertyAnnotations());
	}

	/**
	 * Return an list of class inspector from cache by given path and annotation
	 *
	 * @param string       $annotation
	 * @param string       $path
	 * @param CachedReader $cachedReader
	 *
	 * @return ClassAnnotation[]
	 */
	public function getInfoByPath(string $annotation, string $path, CachedReader $cachedReader): array
	{
		$key = $path . "@" . $annotation;
		if (!isset($this->finder[$key])) {
			$this->finder[$key] = [];
			$finder = new Finder();
			$finder->containsAtLeastOneOf($annotation)->setReader($cachedReader)->in($path);
			foreach ($finder as $file) {
				$classInspector = $this->getFileInspector($file)->getClassInspector($cachedReader);
				$this->finder[$key][] = new ClassAnnotation($classInspector->getClassName(), $classInspector->getClassAnnotations(), $classInspector->getMethodAnnotations(), $classInspector->getPropertyAnnotations());
			}
			$this->updateCache();
		}

		return $this->finder[$key];
	}

	/**
	 * @param SplFileInfo $file
	 *
	 * @return FileInspector
	 */
	private function getFileInspector(SplFileInfo $file): FileInspector
	{
		return new FileInspector($file->getRealPath());
	}

	/**
	 * Update the cache
	 */
	protected function updateCache(): void
	{
		$this->cacheItem->set([
			"annotations" => $this->annotations,
			"finder"     => $this->finder
		])->expiresAfter($this->maxLifetime);

		RouteCMS::instance()->getCache()->save($this->cacheItem);
	}

	/**
	 * @inheritdoc
	 */
	protected function init(): void
	{
		parent::init();
		$cache = $this->getCache();
		if ($cache !== null && isset($cache["annotations"])) $this->annotations = $cache["annotations"];
		if ($cache !== null && isset($cache["finder"])) $this->finder = $cache["finder"];
	}
}