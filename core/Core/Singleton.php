<?php

namespace RouteCMS\Core;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
trait Singleton
{

	/**
	 * @var    Singleton[]
	 */
	protected static $__singletonObjects = [];

	/**
	 * Disabled constructor for a singleton
	 */
	protected final function __construct()
	{
		$this->init();
	}

	/**
	 * Get instance of a singleton
	 *
	 * @return    static
	 */
	public static final function instance()
	{
		$className = get_called_class();
		if (!array_key_exists($className, self::$__singletonObjects)) {
			self::$__singletonObjects[$className] = null;
			self::$__singletonObjects[$className] = new $className();
		}

		return self::$__singletonObjects[$className];
	}

	/**
	 * Check if this singleton all ready initialized
	 *
	 * @return    boolean
	 */
	public static final function isInitialized(): bool
	{
		$className = get_called_class();

		return isset(self::$__singletonObjects[$className]);
	}

	/**
	 * Disallowed object serializing
	 *
	 * @throws \Exception
	 */
	public final function __sleep()
	{
		throw new \Exception('Serializing of Singletons is not allowed');
	}

	/**
	 * Overwrite constructor function for a singleton
	 */
	protected function init(): void
	{
	}

	/**
	 * Disallow object cloning
	 */
	protected final function __clone()
	{
	}
}
