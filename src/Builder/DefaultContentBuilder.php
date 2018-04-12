<?php
declare(strict_types=1);

namespace RouteCMS\Builder;

use RouteCMS\Builder\Content\Content;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class DefaultContentBuilder implements ContentBuilder
{

	/**
	 * @var Content[] 
	 */
	protected $elements = [];

	/**
	 * @var string 
	 */
	protected $tag;

	/**
	 * @inheritDoc
	 */
	public function __construct(string $tag)
	{
		$this->tag = $tag;
	}
	
	/**
	 * @inheritdoc
	 */
	public function addContent(Content $content): ContentBuilder
	{
		$this->elements[] = $content;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTag(): string
	{
		return $this->tag;
	}

	/**
	 * @return Content[]
	 */
	public function getElements(): array
	{
		return $this->elements;
	}

	/**
	 * @inheritdoc
	 */
	public function getHtml(): string
	{
		global $event;
		$result = "";
		$param = [
			"result" => &$result,
			"elements" => &$this->elements
		];
		$event->call("beforeParse", $this, $param);
		foreach($this->elements as $element){
			$result .= $element->getHtml();
		}
		$event->call("afterParse", $this, $param);

		return $result;
	}
}