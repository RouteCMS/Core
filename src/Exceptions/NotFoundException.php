<?php
declare(strict_types=1);

namespace RouteCMS\Exceptions;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class NotFoundException extends UserException implements IPrintableException
{

	/**
	 * @inheritdoc
	 */
	public function show(): void
	{
		@header('HTTP/1.0 404 Not Found');
		echo "404";
		//TODO show 404 page
		exit;
	}
}