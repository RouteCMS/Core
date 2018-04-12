<?php
declare(strict_types=1);

namespace RouteCMS\Annotations\Controller;

use RouteCMS\Builder\Content\Input\FormTypes;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class FormElement
{

	/**
	 * @var string
	 */
	public $type = FormTypes::TEXT;

	/**
	 * @var string
	 */
	public $placeholder = "";

	/**
	 * @var array
	 */
	public $properties = [];

	/**
	 * @var array
	 */
	public $classList = [];
}