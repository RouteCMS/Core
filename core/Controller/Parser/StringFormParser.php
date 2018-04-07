<?php
declare(strict_types=1);

namespace RouteCMS\Controller\Parser;

use RouteCMS\Exceptions\InputException;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class StringFormParser extends DefaultFormParser
{

	/**
	 * @inheritdoc
	 */
	public function validateValue()
	{
		if (empty($this->value)) {
			throw new InputException($this->getName());
		}
		//TODO dynamic language value for exception
		//check min length
		$minLength = $this->getOption("minLength", "int", 0);
		if ($minLength > 0 && mb_strlen($this->value) < $minLength) {
			throw new InputException($this->getName(), "minLength");
		}

		//check max length
		$maxLength = $this->getOption("maxLength", "int", 0);
		if ($maxLength > 0 && mb_strlen($this->value) > $maxLength) {
			throw new InputException($this->getName(), "maxLength");
		}
	}
}