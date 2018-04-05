<?php

namespace RouteCMS\Exceptions;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
interface IPrintableException
{

	/**
	 * Output the exception message
	 */
	public function show();
}