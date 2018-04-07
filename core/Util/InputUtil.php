<?php
declare(strict_types=1);

namespace RouteCMS\Util;

/**
 * @author        Olaf Braun <info@braun-development.de>
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
	public static function isPost(): bool
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
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function arrayRequest(string $var, string $type = '', array $allowed, $default = null)
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
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function request(string $var, string $type = '', $default = null)
	{
		return self::format($_REQUEST, $var, $type, $default);
	}

	/**
	 * Format a header variable
	 *
	 * @param array  $input
	 * @param string $var
	 * @param string $type
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function format(array $input, string $var, string $type, $default = null)
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
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function arrayPost(string $var, string $type = '', array $allowed, $default = null)
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
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function post(string $var, string $type = '', $default = null)
	{
		return self::format($_POST, $var, $type, $default);
	}

	/**
	 * @param string $var
	 * @param string $type
	 * @param array  $allowed
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function arrayGet(string $var, string $type = '', array $allowed, $default = null)
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
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function get(string $var, string $type = '', $default = null)
	{
		return self::format($_GET, $var, $type, $default);
	}

	/**
	 * @param string $var
	 * @param string $type
	 * @param array  $allowed
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function arrayServer(string $var, string $type = '', array $allowed, $default = null)
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
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function server(string $var, string $type = '', $default = null)
	{
		return self::format($_SERVER, $var, $type, $default);
	}

	/**
	 * @param string $var
	 * @param string $type
	 * @param array  $allowed
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function arrayCookie(string $var, string $type = '', array $allowed, $default = null)
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
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function files(string $var, string $type = '', $default = null)
	{
		return self::format($_FILES, $var, $type, $default);
	}

	/**
	 * Return a COOKIE variable
	 *
	 * @param string $var
	 * @param string $type
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function cookie(string $var, string $type = '', $default = null)
	{
		return self::format($_COOKIE, $var, $type, $default);
	}
}