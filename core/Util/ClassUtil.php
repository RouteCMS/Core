<?php
declare(strict_types=1);

namespace RouteCMS\Util;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
final class ClassUtil
{

	/**
	 * @param string $class
	 *
	 * @return bool
	 */
	public static function isAbstract(string $class): bool
	{
		$a = new \ReflectionClass($class);

		return $a->isAbstract();
	}
}