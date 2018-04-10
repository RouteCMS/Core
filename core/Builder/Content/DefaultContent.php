<?php
declare(strict_types=1);

namespace RouteCMS\Builder\Content;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class DefaultContent implements Content
{

	/**
	 * @var string
	 */
	protected $tag = "div";

	/**
	 * @var string
	 */
	protected $content = "";

	/**
	 * @var string[]
	 */
	protected $classList = [];

	/**
	 * @var string
	 */
	protected $id = "";

	/**
	 * @var string[]
	 */
	protected $propertyList = [];

	/**
	 * @inheritDoc
	 */
	public function __construct(string $tag = "", string $content = "")
	{
		if (!empty($tag)) $this->tag = $tag;
		$this->content = $content;
	}

	/**
	 * @return string[]
	 */
	public function getClassList(): array
	{
		return $this->classList;
	}

	/**
	 * @return string
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 */
	public function setId(string $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getTag(): string
	{
		return $this->tag;
	}

	/**
	 * @return string[]
	 */
	public function getPropertyList(): array
	{
		return $this->propertyList;
	}

	/**
	 * Say if an class in the class list for this element
	 *
	 * @param string $class
	 *
	 * @return bool
	 */
	public function hasClass(string $class): bool
	{
		return in_array($class, $this->classList);
	}

	/**
	 * Return the value of an property key or `null` if this key not in the list
	 *
	 * @param string $key
	 *
	 * @return null|string
	 */
	public function getPropertyValue(string $key): ?string
	{
		return isset($this->propertyList[$key]) ? $this->propertyList[$key] : null;
	}

	/**
	 * @param string $class
	 */
	public function addClass(string $class): void
	{
		$this->classList[] = $class;
		$this->classList = array_unique($this->classList);
	}

	/**
	 * Add an special property or overwrite it
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function addPropertyValue(string $key, string $value): void
	{
		$this->propertyList[$key] = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function getHtml(): string
	{
		$html = "<$this->tag";
		if (count($this->classList) > 0) $html .= ' class="' . implode(" ", $this->classList) . '"';
		foreach ($this->classList as $key => $value) {
			$html .= ' ' . $key . '="' . $value . '"';
		}
		$html .= ">";
		$html .= $this->getContent();
		$html .= "</$this->tag>";

		return $html;
	}

	/**
	 * Return the content of this element
	 *
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->content;
	}
}