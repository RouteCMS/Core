<?php

namespace RouteCMS\Exceptions;


/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
class NotFoundException extends UserException
{

	/**
	 * @inheritdoc
	 */
	public function show()
	{
		//TODO show 404 page
	}
}