<?php
declare(strict_types=1);

namespace RouteCMS\Builder\Content\Input;

use RouteCMS\Builder\Content\DefaultContent;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
abstract class DefaultInput extends DefaultContent implements FormElement
{

	/**
	 * @var string 
	 */
	protected $type = FormTypes::TEXT;

	/**
	 * @var string 
	 */
	protected $value = "";

	/**
	 * DefaultInput constructor.
	 *
	 * @param string $value
	 */
	public function __construct(string $value)
	{
		parent::__construct("input");
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}
}