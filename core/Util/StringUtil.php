<?php
declare(strict_types=1);

namespace RouteCMS\Util;

use RouteCMS\Exceptions\SystemException;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class StringUtil
{

	/**
	 * Encode a HTML String
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function htmlEncode(string $string): string
	{
		return @htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
	}

	/**
	 * Create a random id
	 *
	 * @return    string
	 */
	public static function getRandomID(): string
	{
		return self::randomString();
	}

	/**
	 * Generate random strings
	 *
	 * @param int $length
	 *
	 * @return string
	 */
	public static function randomString(int $length = 16)
	{
		if (function_exists('random_bytes')) {
			return bin2hex(random_bytes($length));
		}
		if (function_exists('openssl_random_pseudo_bytes')) {
			return bin2hex(openssl_random_pseudo_bytes($length));
		}
		throw new SystemException("Cannot generate a secure random string");
	}

	/**
	 * Decodes html string
	 *
	 * @param    string $string
	 *
	 * @return    string
	 */
	public static function decodeHTML(string $string): string
	{
		$string = str_ireplace('&nbsp;', ' ', $string);

		return @html_entity_decode($string, ENT_COMPAT, 'UTF-8');
	}

	/**
	 * Remove backslashes
	 *
	 * @param    string $text
	 *
	 * @return    string
	 */
	public static function trim(string $text): string
	{
		$text = trim($text);
		$text = preg_replace('/^[\p{Zs}\s]+/u', '', $text);
		$text = preg_replace('/[\p{Zs}\s]+$/u', '', $text);

		return $text;
	}

	/**
	 * Convert encoding to another one
	 *
	 * @see        mb_convert_encoding()
	 *
	 * @param    string $inCharset
	 * @param    string $outCharset
	 * @param    string $string
	 *
	 * @return    string        converted string
	 */
	public static function convertEncoding(string $inCharset, string $outCharset, string $string): string
	{
		if ($inCharset == 'ISO-8859-1' && $outCharset == 'UTF-8')
			return utf8_encode($string);
		if ($inCharset == 'UTF-8' && $outCharset == 'ISO-8859-1')
			return utf8_decode($string);

		return mb_convert_encoding($string, $outCharset, $inCharset);
	}

	/**
	 * Gibt zuück ob eine String UTF-8 codiert ist
	 *
	 * @see        http://www.w3.org/International/questions/qa-forms-utf-8
	 *
	 * @param    string $string
	 *
	 * @return    boolean
	 */
	public static function isUTF8(string $string)
	{
		return preg_match('/(
				[\xC2-\xDF][\x80-\xBF]			# non-overlong 2-byte
			|	\xE0[\xA0-\xBF][\x80-\xBF]		# excluding overlongs
			|	[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}	# straight 3-byte
			|	\xED[\x80-\x9F][\x80-\xBF]		# excluding surrogates
			|	\xF0[\x90-\xBF][\x80-\xBF]{2}		# planes 1-3
			|	[\xF1-\xF3][\x80-\xBF]{3}		# planes 4-15
			|	\xF4[\x80-\x8F][\x80-\xBF]{2}		# plane 16
			)/x', $string);
	}

	/**
	 * @param string $str
	 * @param string $need
	 * @param bool   $case
	 *
	 * @return bool
	 */
	public static function endsWith(string $str, string $need, bool $case = false)
	{
		if ($case) {
			$str = mb_strtolower($str);
			$need = mb_strtolower($need);
		}
		$length = mb_strlen($need);
		if ($length === 0) return true;

		return (mb_substr($str, $length * -1) === $need);
	}

	/**
	 * Check if a string starts with a special string
	 *
	 * @param string $need
	 * @param string $str
	 * @param bool   $case
	 *
	 * @return bool
	 */
	public static function startsWith(string $need, string $str, bool $case = false): bool
	{
		if ($case) {
			$str = mb_strtolower($str);
			$need = mb_strtolower($need);
		}

		return mb_substr($str, 0, mb_strlen($need)) === $need;
	}
}