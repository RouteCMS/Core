<?php
declare(strict_types=1);

namespace RouteCMS\Builder\Content;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class PlainContent implements Content
{

	/**
	 * The plain html content
	 * 
	 * @var string 
	 */
	protected $html = "";

	/**
	 * Constructor for an plain html object
	 *
	 * @param string $html
	 */
	public function __construct(string $html)
	{
		$this->html = $html;
	}

	/**
	 * @inheritdoc
	 */
	public function getHtml(): string
	{
		return $this->html;
	}
}