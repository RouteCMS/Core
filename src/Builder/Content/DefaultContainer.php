<?php
declare(strict_types=1);

namespace RouteCMS\Builder\Content;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class DefaultContainer extends DefaultContent implements Container
{

	/**
	 * @var string
	 */
	protected $tag = "div";

	/**
	 * @var Content[]
	 */
	protected $elements = [];

	/**
	 * @inheritDoc
	 */
	public function __construct()
	{
		//empty default constructor
	}

	/**
	 * @inheritdoc
	 */
	public function addContent(Content $element): Container
	{
		$this->elements[] = $element;

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getElements(): array
	{
		return $this->elements;
	}

	/**
	 * @inheritDoc
	 */
	public function getContent(): string
	{
		$html = "";
		foreach ($this->elements as $element) {
			$html .= $element->getHtml();
		}

		return $html;
	}
}