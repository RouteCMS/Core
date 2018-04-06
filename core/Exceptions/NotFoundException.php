<?php
declare(strict_types=1);

namespace RouteCMS\Exceptions;


/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class NotFoundException extends UserException
{

	/**
	 * @inheritdoc
	 */
	public function show(): void
	{
		//TODO show 404 page
	}
}