<?php
declare(strict_types=1);

namespace RouteCMS\Exceptions;

use Whoops\Handler\Handler;
use Whoops\Handler\PrettyPageHandler;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
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