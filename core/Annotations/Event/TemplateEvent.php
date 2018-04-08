<?php
declare(strict_types=1);

namespace RouteCMS\Annotations\Event;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Annotation
 * @Target("CLASS")
 */
class TemplateEvent
{

	/**
	 * @var string
	 * @Required
	 */
	public $name;

	/**
	 * @var integer
	 */
	public $priority = 10;
}