<?php
declare(strict_types=1);

namespace RouteCMS\Builder\Content;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
interface Container extends Content
{

	/**
	 * @param Content $element
	 *
	 * @return Container
	 */
	public function addContent(Content $element): Container;

	/**
	 * Return all elements from this container
	 *
	 * @return Content[]
	 */
	public function getElements(): array;

	/**
	 * @inheritDoc
	 */
	public function getContent(): string;
}