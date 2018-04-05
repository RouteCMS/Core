<?php

namespace RouteCMS\Util;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
final class SystemUtil
{

	/**
	 * memory limit in bytes
	 *
	 * @var    integer
	 */
	protected static $memoryLimit = null;

	/**
	 * Returns memory limit in bytes.
	 *
	 * @return    integer
	 */
	public static function getMemoryLimit()
	{
		if (self::$memoryLimit === null) {
			self::$memoryLimit = 0;

			$memoryLimit = ini_get('memory_limit');

			// no limit
			if ($memoryLimit == -1) {
				self::$memoryLimit = -1;
			}

			// completely numeric, PHP assumes byte
			if (is_numeric($memoryLimit)) {
				self::$memoryLimit = $memoryLimit;
			}

			// PHP supports 'K', 'M' and 'G' shorthand notation
			if (preg_match('~^(\d+)([KMG])$~', $memoryLimit, $matches)) {
				switch ($matches[2]) {
					case 'K':
						self::$memoryLimit = $matches[1] * 1024;
						break;

					case 'M':
						self::$memoryLimit = $matches[1] * 1024 * 1024;
						break;

					case 'G':
						self::$memoryLimit = $matches[1] * 1024 * 1024 * 1024;
						break;
				}
			}
		}

		return self::$memoryLimit;
	}
}