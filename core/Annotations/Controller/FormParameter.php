<?php
declare(strict_types=1);

namespace RouteCMS\Annotations\Controller;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class FormParameter
{

	/**
	 * @var string
	 */
	public $type = "string";

	/**
	 * @var string
	 * @Required
	 */
	public $name = null;

	/**
	 * @var mixed
	 */
	public $default = null;

	/**
	 * @var array
	 */
	public $options = [];
}