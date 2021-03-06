<?php
declare(strict_types=1);

namespace RouteCMS\Controller\Parser;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class BoolFormParser extends DefaultFormParser
{

	/**
	 * @var string
	 */
	protected $type = "bool";

	/**
	 * @var string
	 */
	protected $default = false;
}