<?php
declare(strict_types=1);

namespace RouteCMS\Annotations\Database;

use Doctrine\Common\Annotations\Annotation\Target;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Annotation
 * @Target({"CLASS"})
 */
class ModelCache
{

	/**
	 * Time in seconds
	 *
	 * @var int
	 */
	public $time = 60 * 5;
}