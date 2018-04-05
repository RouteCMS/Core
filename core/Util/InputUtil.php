<?php

namespace RouteCMS\Util;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class InputUtil
{

	/**
	 * Check if some content send to the server
	 *
	 * @return boolean
	 */
	public static function isPost()
	{
		if (!empty($_POST) && count($_POST)) {
			return true;
		}

		return false;
	}

	/**
	 * @param string $var
	 * @param string $type
	 * @param array  $allowed
	 * @param null   $default
	 *
	 * @return mixed
	 */
	public static function arrayRequest($var, $type = '', $allowed, $default = null)
	{
		$current = self::request($var, $type, $default);
		if (!in_array($current, $allowed)) {
			return $default;
		}

		return $current;
	}

	/**
	 * Return a REQUEST variable
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return mixed
	 */
	public static function request($var, $type = '', $default = null)
	{
		return self::format($_REQUEST, $var, $type, $default);
	}

	/**
	 * Format a header variable
	 *
	 * @param array  $input
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return mixed
	 */
	public static function format($input, $var, $type, $default = null)
	{
		if (isset($input[$var])) {
			switch (strtolower($type)) {
				case 'bool':
				case 'boolean':
					return (boolean)$input[$var];

				case 'int':
				case 'integer':
					return (int)$input[$var];

				case 'double':
					return (double)$input[$var];

				case 'float':
					return (float)$input[$var];

				case 'string':
					return StringUtil::trim((string)$input[$var]);

				case 'object':
					return (object)$input[$var];

				case 'array':
					return (empty($input[$var])) ? [] : (array)$input[$var];

				case '':
					return $input[$var];
			}
		}

		return $default;
	}

	/**
	 * @param string $var
	 * @param string $type
	 * @param array  $allowed
	 * @param null   $default
	 *
	 * @return mixed
	 */
	public static function arrayPost($var, $type = '', $allowed, $default = null)
	{
		$current = self::post($var, $type, $default);
		if (!in_array($current, $allowed)) {
			return $default;
		}

		return $current;
	}

	/**
	 * Return a POST variable
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return mixed
	 */
	public static function post($var, $type = '', $default = null)
	{
		return self::format($_POST, $var, $type, $default);
	}

	/**
	 * @param string $var
	 * @param string $type
	 * @param array  $allowed
	 * @param null   $default
	 *
	 * @return mixed
	 */
	public static function arrayGet($var, $type = '', $allowed, $default = null)
	{
		$current = self::get($var, $type, $default);
		if (!in_array($current, $allowed)) {
			return $default;
		}

		return $current;
	}

	/**
	 * Return a GET variable
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return mixed
	 */
	public static function get($var, $type = '', $default = null)
	{
		return self::format($_GET, $var, $type, $default);
	}

	/**
	 * @param string $var
	 * @param string $type
	 * @param array  $allowed
	 * @param null   $default
	 *
	 * @return mixed
	 */
	public static function arrayServer($var, $type = '', $allowed, $default = null)
	{
		$current = self::server($var, $type, $default);
		if (!in_array($current, $allowed)) {
			return $default;
		}

		return $current;
	}

	/**
	 * Return a SERVER variable
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return mixed
	 */
	public static function server($var, $type = '', $default = null)
	{
		return self::format($_SERVER, $var, $type, $default);
	}

	/**
	 * @param string $var
	 * @param string $type
	 * @param array  $allowed
	 * @param null   $default
	 *
	 * @return mixed
	 */
	public static function arrayCookie($var, $type = '', $allowed, $default = null)
	{
		$current = self::server($var, $type, $default);
		if (!in_array($current, $allowed)) {
			return $default;
		}

		return $current;
	}

	/**
	 * Return a FILES variable
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return mixed
	 */
	public static function files($var, $type = '', $default = null)
	{
		return self::format($_FILES, $var, $type, $default);
	}

	/**
	 * Return a COOKIE variable
	 *
	 * @param string $var
	 * @param string $type
	 * @param string $default
	 *
	 * @return mixed
	 */
	public static function cookie($var, $type = '', $default = null)
	{
		return self::format($_COOKIE, $var, $type, $default);
	}
}