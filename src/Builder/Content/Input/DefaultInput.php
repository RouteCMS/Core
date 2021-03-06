<?php
declare(strict_types=1);

namespace RouteCMS\Builder\Content\Input;

use RouteCMS\Builder\Content\DefaultContent;
use RouteCMS\Util\StringUtil;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class DefaultInput extends DefaultContent implements FormElement
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
	 * @var string
	 */
	protected $name = "";

	/**
	 * DefaultInput constructor.
	 *
	 * @param string $value
	 * @param string $type
	 * @param string $name
	 */
	public function __construct(string $value, string $type, string $name)
	{
		if (!empty($type)) $this->type = $type;
		parent::__construct("input");
		$this->value = $value;
		$this->name = $name;
	}

	/**
	 * @inheritDoc
	 */
	public function getHtml(): string
	{
		//update value on property list, because they don´t able to overwrite
		$this->addPropertyValue("value", StringUtil::htmlEncode($this->getValue()));
		$this->addPropertyValue("type", $this->type);
		$this->addPropertyValue("name", $this->name);
		return parent::getHtml(); 
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @inheritdoc
	 */
	public function getContent(): string
	{
		return "";
	}
}