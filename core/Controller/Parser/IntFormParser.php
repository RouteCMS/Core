<?php

namespace RouteCMS\Controller\Parser;

use RouteCMS\Exceptions\InputException;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class IntFormParser extends DefaultFormParser
{

	/**
	 * @var string
	 */
	protected $type = "int";

	/**
	 * @var string
	 */
	protected $default = 0;

	/**
	 * @inheritdoc
	 */
	public function validateValue()
	{
		if ($this->value == 0 && !$this->getOption("canEmpty", "bool", false)) {
			throw new InputException($this->getName());
		}
	}
}