<?php

namespace RouteCMS\Exceptions;


/**
 * @author        Olaf Braun
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
	 * @var string
	 */
	private $type;

	/**
	 * InputException constructor.
	 *
	 * @param string $field
	 * @param string $message
	 */
	public function __construct($field, $message = 'Bitte ausfüllen')
	{
		$this->field = $field;
		$this->type = $message;
		parent::__construct();
	}

	/**
	 * Output the exception message
	 */
	public function show(): void
	{

	}

	/**
	 * @return mixed
	 */
	public function getField(): string
	{
		return $this->field;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}
}