<?php
declare(strict_types=1);

namespace RouteCMS\Annotations\controller;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class RequestParameter
{

	/**
	 * @var int
	 * @Required
	 */
	public $position = 0;

	/**
	 * @var mixed
	 */
	public $default = null;
}