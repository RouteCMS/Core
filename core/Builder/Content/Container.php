<?php
declare(strict_types=1);

namespace RouteCMS\Builder\Content;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
abstract class Container implements Content
{

	/**
	 * @var Content[]
	 */
	protected $elements = [];

	/**
	 * @param Content $element
	 *
	 * @return Container
	 */
	public function addContent(Content $element): Container
	{
		$this->elements[] = $element;

		return $this;
	}

	/**
	 * Return all elements from this container
	 *
	 * @return Content[]
	 */
	public function getElements(): array
	{
		return $this->elements;
	}

	/**
	 * @inheritDoc
	 */
	public function getHtml(): string
	{
		$html = "";
		foreach ($this->elements as $element) {
			$html .= $element->getHtml();
		}

		return $html;
	}
}