<?php
declare(strict_types=1);

namespace RouteCMS\Builder\Bootstrap\Content;

use RouteCMS\Builder\Content\DefaultContainer;
use RouteCMS\Builder\Content\DefaultContent;
use RouteCMS\Builder\Content\Input\DefaultInput;
use RouteCMS\Builder\Content\Input\FormTypes;
use RouteCMS\Builder\Content\PlainContent;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class InputGroup extends DefaultContainer
{

	const TEXT = "text";

	const CONTENT = "default";

	/**
	 * @inheritdoc
	 */
	public $classList = ['input-group', 'mb-3'];

	/**
	 * Add an prepend text
	 *
	 * @param string $content
	 *
	 * @return InputGroup
	 */
	public function addPrependText(string $content): InputGroup
	{
		$this->addPrependContent([
			self::TEXT => $content
		]);

		return $this;
	}

	/**
	 * Add an prepend element
	 *
	 * @param array $items
	 *
	 * @return InputGroup
	 */
	public function addPrependContent(array $items): InputGroup
	{
		$div = new DefaultContainer();
		$div->addClass('input-group-prepend');
		foreach ($items as $type => $item) {
			switch ($type) {
				case self::TEXT:
					$div->addContent((new DefaultContent("span", $item))->addClass('input-group-text'));
					break;
				case self::CONTENT:
				default:
					$div->addContent(new PlainContent($item));
					break;
			}
		}
		$this->addContent($div);

		return $this;
	}

	/**
	 * Add an input type
	 *
	 * @param string $value
	 * @param string $type
	 * @param string $name
	 * @param string $placeholder
	 * @param array  $classList
	 * @param array  $properties
	 *
	 * @return InputGroup
	 */
	public function addInput(string $value, string $type = FormTypes::TEXT, string $name = "", string $placeholder = "", array $classList = [], array $properties = []): InputGroup
	{
		$this->addContent(
			(new DefaultInput($value, $type, $name))
				->addClasses($classList)
				->addClass("form-control")
				->addPropertyValues($properties)
				->addPropertyValue("placeholder", $placeholder)
		);

		return $this;
	}

	/**
	 * Add an prepend font awesome icon
	 *
	 * @param string $icon
	 *
	 * @return InputGroup
	 */
	public function addPrependIcon(string $icon): InputGroup
	{
		$this->addPrependContent([
			self::TEXT => '<span class="fa fa-' . $icon . '" aria-hidden="true"></span>'
		]);

		return $this;
	}
}