<?php
declare(strict_types=1);

namespace RouteCMS\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;


/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Annotation
 * @Target("ANNOTATION")
 */
class Event
{

	/**
	 * @var string
	 * @Required
	 */
	public $name;

	/**
	 * @var string
	 * @Required
	 */
	public $class;

	/**
	 * @var integer
	 */
	public $priority = 10;

	/**
	 * Return the identifier vor this event
	 *
	 * @return string
	 */
	public function getIdentifier()
	{
		return $this->class . "@" . $this->name;
	}
}