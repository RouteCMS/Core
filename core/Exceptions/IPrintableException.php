<?php

namespace RouteCMS\Exceptions;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
interface IPrintableException
{

	/**
	 * Output the exception message
	 */
	public function show();
}