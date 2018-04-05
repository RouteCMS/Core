<?php

namespace RouteCMS;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
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
	public static final function isInitialized()
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
	protected function init()
	{
	}

	/**
	 * Disallow object cloning
	 */
	protected final function __clone()
	{
	}
}