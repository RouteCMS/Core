<?php

namespace RouteCMS\Util;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
 */
final class HeaderUtil
{

	/**
	 * Redirects the user agent to given location.
	 *
	 * @param    string  $location
	 * @param    boolean $sendStatusCode
	 * @param    boolean $temporaryRedirect
	 */
	public static function redirect(string $location, bool $sendStatusCode = false, bool $temporaryRedirect = true)
	{
		if ($sendStatusCode) {
			if ($temporaryRedirect) @header('HTTP/1.1 307 Temporary Redirect');
			else @header('HTTP/1.0 301 Moved Permanently');
		}

		header('Location: ' . $location);
	}

	/**
	 * @param string $path
	 * @param bool   $isAdmin
	 *
	 * @return string
	 */
	public static function createLink(string $path, bool $isAdmin = false)
	{
		return (DOMAIN_HTTPS ? "https://" : "http://") . DOMAIN . DOMAIN_PATH . "/" . ($isAdmin ? "admin/" : "") . $path;
	}
}