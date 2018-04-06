<?php
declare(strict_types=1);

namespace RouteCMS\Event;

use RouteCMS\Core\Singleton;


/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class EventHandler
{

	use Singleton;

	/**
	 * @param string $name
	 * @param mixed  $object
	 * @param array  $parameters
	 */
	public function call(string $name, $object, array &$parameters): void
	{
		//TODO read all event listener for a special event and call them
	}
}