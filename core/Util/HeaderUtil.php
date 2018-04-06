<?php
declare(strict_types=1);

namespace RouteCMS\Util;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
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
	public static function redirect(string $location, bool $sendStatusCode = false, bool $temporaryRedirect = true): void
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
	public static function createLink(string $path, bool $isAdmin = false): string
	{
		return (DOMAIN_HTTPS ? "https://" : "http://") . DOMAIN . DOMAIN_PATH . "/" . ($isAdmin ? "admin/" : "") . $path;
	}
}