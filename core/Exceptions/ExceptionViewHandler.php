<?php

namespace RouteCMS\Exceptions;

use Whoops\Handler\Handler;
use Whoops\Handler\PrettyPageHandler;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
 */
class ExceptionViewHandler extends PrettyPageHandler
{

	/**
	 * @inheritDoc
	 */
	public function handle()
	{
		$ex = $this->getException();
		if ($ex instanceof IPrintableException) {
			$ex->show();

			return Handler::QUIT;
		}

		return parent::handle();
	}
}