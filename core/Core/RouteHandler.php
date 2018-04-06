<?php
declare(strict_types=1);

namespace RouteCMS\Core;

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use RouteCMS\Cache\ControllerCache;
use RouteCMS\Exceptions\NotFoundException;
use RouteCMS\Util\InputUtil;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class RouteHandler
{

	use Singleton;

	/**
	 * Handel the current request
	 *
	 * @throws NotFoundException
	 */
	public function handle()
	{
		$dispatcher = new Dispatcher(ControllerCache::instance()->getCollector()->getData());
		try {
			$dispatcher->dispatch(InputUtil::server("REQUEST_METHOD", "string", "GET"), CURRENT_URI);
		} catch (HttpRouteNotFoundException $ex) {
			throw new NotFoundException();
		}
	}
}