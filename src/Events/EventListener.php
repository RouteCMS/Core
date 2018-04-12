<?php

namespace RouteCMS\Events;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
interface EventListener
{

	/**
	 * Execute a event
	 * 
	 * @param string $name
	 * @param mixed  $object
	 * @param array  $parameters
	 */
	public function fire($name, $object, array &$parameters = []): void;
}