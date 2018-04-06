<?php

namespace RouteCMS\Controller\Parser;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
interface FormParser
{

	/**
	 * @param string $name
	 * @param mixed  $default
	 * @param array  $options
	 */
	public function __construct($name, $default = null, array $options = []);

	/**
	 * Return the value from post content
	 *
	 * @return mixed
	 */
	public function returnValue();

	/**
	 * Return the name of the variable
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Add one option
	 *
	 * @param string $name
	 * @param mixed  $value
	 */
	public function addOption($name, $value);

	/**
	 * Add options
	 *
	 * @param array $values
	 */
	public function addOptions(array $values);

	/**
	 * Return a option value by given name or default if not exist
	 *
	 * @param string $name
	 * @param string $type
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public function getOption($name, $type = "string", $default = null);

	/**
	 * Return the current value
	 *
	 * @return mixed
	 */
	public function getValue();

	/**
	 * Validate the value of given
	 *
	 * @return mixed
	 */
	public function validateValue();
}