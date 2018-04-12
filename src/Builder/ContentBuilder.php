<?php
declare(strict_types=1);

namespace RouteCMS\Builder;

use RouteCMS\Builder\Content\Content;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
interface ContentBuilder
{

	/**
	 * @param Content $content
	 *
	 * @return ContentBuilder
	 */
	public function addContent(Content $content): ContentBuilder;

	/**
	 * @return string
	 */
	public function getHtml(): string;

	/**
	 * @return string
	 */
	public function getTag(): string;
}