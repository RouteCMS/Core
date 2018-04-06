<?php
declare(strict_types=1);

namespace RouteCMS\Controller\Parser;

use RouteCMS\Util\InputUtil;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
abstract class DefaultFormParser implements FormParser
{

	/**
	 * @var string
	 */
	protected $type = "string";

	/**
	 * @var string
	 */
	protected $default = "";

	/**
	 * @var null
	 */
	protected $value = null;

	/***
	 * @var array
	 */
	protected $options = [];

	/**
	 * @var string
	 */
	private $name = "";

	/**
	 * @inheritdoc
	 */
	public function __construct($name, $default = null, array $options = [])
	{
		$this->name = $name;
		if ($default !== null) $this->default = $default;
		$this->options = $options;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}


	/**
	 * @inheritdoc
	 */
	public function addOption($name, $value)
	{
		$this->addOptions([
			$name => $value
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function addOptions(array $values)
	{
		foreach ($values as $name => $value) {
			$this->options[$name] = $value;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function getOption($name, $type = "string", $default = null)
	{
		return InputUtil::format($this->options, $name, $type, $default);
	}

	/**
	 * @inheritdoc
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @inheritdoc
	 */
	public function returnValue()
	{
		$this->value = InputUtil::post($this->name, $this->type, $this->default);
	}

	/**
	 * @inheritdoc
	 */
	public function validateValue()
	{
		//do nothing
	}
}