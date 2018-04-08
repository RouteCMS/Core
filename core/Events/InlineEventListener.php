<?php

namespace RouteCMS\Events;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
interface InlineEventListener
{

	/**
	 * Execute an inline event
	 * 
	 * @param string $name
	 * @param array  $parameters
	 */
	public function fire($name, array &$parameters = []): void;
}