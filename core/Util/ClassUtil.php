<?php

namespace RouteCMS\Util;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
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