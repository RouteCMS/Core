<?php

namespace RouteCMS\Annotations\Database;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Annotation
 * @Target({"CLASS"})
 */
class EnumColumn
{
	/**
	 * @var string
	 */
	public $name = "";
}