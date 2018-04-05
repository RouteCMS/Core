<?php

namespace RouteCMS\Exceptions;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
 */
class PermissionDeniedException extends UserException
{

	/**
	 * @inheritdoc
	 */
	public function show()
	{
		//TODO show 403 page
	}
}