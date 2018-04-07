<?php
declare(strict_types=1);

namespace RouteCMS\Util;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class UserUtil
{

	/**
	 * Return the IP-Address from the user
	 *
	 * @return string
	 */
	public static function getIpAddress(): string
	{
		$ip = '';
		if (isset($_SERVER['REMOTE_ADDR']))
			$ip = $_SERVER['REMOTE_ADDR'];

		if ($ip == '::1' || $ip == 'fe80::1') {
			$ip = '127.0.0.1';
		}

		return $ip;
	}

	/**
	 * Return the user agent
	 *
	 * @return string
	 */
	public static function getUserAgent(): string
	{
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			if (!preg_match('/^[\x00-\x7F]*$/', $userAgent) && !StringUtil::isUTF8($userAgent)) {
				$userAgent = StringUtil::convertEncoding('ISO-8859-1', 'UTF-8', $userAgent);
			}

			return mb_substr($userAgent, 0, 255);
		}

		return '';
	}

	/**
	 * Return the local url
	 *
	 * @return string
	 */
	public static function getUrl(): string
	{
		$url = '';
		if (InputUtil::server("REQUEST_URI", 'string') != '') {
			$url = InputUtil::server("REQUEST_URI", 'string');
		} elseif (InputUtil::server("QUERY_STRING", 'string') != '' && (InputUtil::server("SCRIPT_NAME", 'string') != '' || InputUtil::server("PHP_SELF", 'string') != '')) {
			if (InputUtil::server("SCRIPT_NAME", 'string') != '') {
				$url = InputUtil::server("PHP_SELF", 'string') . '?' . InputUtil::server("QUERY_STRING", 'string');
			} else {
				$url = InputUtil::server("PHP_SELF", 'string') . '?' . InputUtil::server("QUERY_STRING", 'string');
			}
		}
		if (!preg_match('/^[\x00-\x7F]*$/', $url) && !StringUtil::isUTF8($url)) {
			$url = StringUtil::convertEncoding('ISO-8859-1', 'UTF-8', $url);
		}

		return mb_substr($url, 0, 255);
	}


	/**
	 * Validate the e-mail
	 *
	 * @param    string $mail
	 *
	 * @return    boolean
	 */
	public static function isValidEmail(string $mail): bool
	{
		$c = '!#\$%&\'\*\+\-\/0-9=\?a-z\^_`\{\}\|~';
		$string = '[' . $c . ']*(?:\\\\[\x00-\x7F][' . $c . ']*)*';
		$localPart = $string . '(?:\.' . $string . ')*';

		$name = '[a-z0-9](?:[a-z0-9-]*[a-z0-9])?';
		$domain = $name . '(?:\.' . $name . ')*\.[a-z]{2,}';

		$mailbox = $localPart . '@' . $domain;

		return preg_match('/^' . $mailbox . '$/i', $mail);
	}

	/**
	 * Convert a IPv6 Address to an IPv4 Address or return the ipv6
	 *
	 * @param    string $ip
	 *
	 * @return    string
	 */
	public static function convertIPv6To4(string $ip): string
	{
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
			if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
				return '';
			}

			return $ip;
		}

		if (substr($ip, 0, 7) == '::ffff:') {
			$ip = substr($ip, 7);
			if (preg_match('~^([a-f0-9]{1,4}):([a-f0-9]{1,4})$~', $ip, $matches)) {
				$ip = [
					base_convert($matches[1], 16, 10),
					base_convert($matches[2], 16, 10)
				];

				$ipParts = [];
				$tmp = $ip[0] % 256;
				$ipParts[] = ($ip[0] - $tmp) / 256;
				$ipParts[] = $tmp;
				$tmp = $ip[1] % 256;
				$ipParts[] = ($ip[1] - $tmp) / 256;
				$ipParts[] = $tmp;

				return implode('.', $ipParts);
			} else {
				return $ip;
			}
		} else {
			return $ip;
		}
	}
}