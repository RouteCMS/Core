<?php
declare(strict_types=1);

namespace RouteCMS\Cache;

use Performance\Performance;
use Phramz\Doctrine\Annotation\Scanner\ClassInspector;
use Phroute\Phroute\RouteCollector;
use RouteCMS\Annotations\AnnotationHandler;
use RouteCMS\Annotations\Controller\Controller;
use RouteCMS\Core\RouteCMS;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class ControllerCache extends AbstractCache
{

	/**
	 * @inheritdoc
	 */
	protected $maxLifetime = 60 * 60 * 6;

	/**
	 * @var RouteCollector
	 */
	private $collector = null;

	/**
	 * @inheritdoc
	 */
	protected function init(): void
	{
		parent::init();
		if ($this->collector === null) {
			$this->getCollector();
		}
	}

	/**
	 * @return RouteCollector
	 */
	public function getCollector()
	{
		if ($this->collector !== null) return $this->collector;
		$this->collector = $this->getCache();
		if ($this->collector === null || $this->collector === false) {
			$this->updateCache();
		}

		return $this->collector;
	}

	/**
	 * Update the cache
	 */
	protected function updateCache(): void
	{
		Performance::point("ControllerCache@register");
		$this->collector = new RouteCollector();
		AnnotationHandler::instance()->doCall(Controller::class, GLOBAL_DIR . "core/Controller/", function ($classInspector, $annotation) {
			/** @var ClassInspector $classInspector */
			/** @var Controller $annotation */
			$routeController = [$classInspector->getClassName(), "handle"];

			foreach ($annotation->method as $method) {
				$this->collector->addRoute($method, DOMAIN_PATH . ($annotation->admin ? "/admin" : "") . $annotation->path, $routeController);
			}
		});
		$this->cacheItem->set($this->collector)->expiresAfter($this->maxLifetime);

		Performance::finish();

		RouteCMS::instance()->getCache()->save($this->cacheItem);
	}
}