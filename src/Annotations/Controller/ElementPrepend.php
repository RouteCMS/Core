<?php
declare(strict_types=1);

namespace RouteCMS\Annotations\Controller;

use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Annotations\Annotation\Required;
use RouteCMS\Builder\Bootstrap\Content\InputGroup;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class ElementPrepend
{

	/**
	 * @var string
	 * @Enum({"text", "icon", "default"})
	 */
	public $type = InputGroup::TEXT;

	/**
	 * @var string 
	 * @Required
	 */
	public $content = "";

	/**
	 * @var bool 
	 */
	public $before = true;
}