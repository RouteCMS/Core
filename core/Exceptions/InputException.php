<?php

namespace RouteCMS\Exceptions;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class InputException extends UserException
{

	/**
	 * @var string
	 */
	private $field;

	/**
	 * InputException constructor.
	 *
	 * @param string $field
	 * @param string $message
	 */
	public function __construct(string $field, string $message = "")
	{
		$this->field = $field;
		$this->message = $message ?: txt("route-cms/global/form/invalid/empty");
		parent::__construct();
	}

	/**
	 * @return mixed
	 */
	public function getField(): string
	{
		return $this->field;
	}
}