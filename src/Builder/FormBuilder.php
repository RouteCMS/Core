<?php
declare(strict_types=1);

namespace RouteCMS\Builder;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
trait FormBuilder
{

	/**
	 * @var ContentBuilder
	 */
	protected $contentBuilder;

	/**
	 * @return ContentBuilder
	 */
	public function getContentBuilder(): ContentBuilder
	{
		return $this->contentBuilder;
	}
}