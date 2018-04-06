<?php
declare(strict_types=1);

namespace RouteCMS\Exceptions;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class PermissionDeniedException extends UserException
{

	/**
	 * @inheritdoc
	 */
	public function show(): void
	{
		//TODO show 403 page
	}
}