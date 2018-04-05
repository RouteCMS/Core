<?php

namespace RouteCMS;

use Darsyn\IP\Doctrine\IpType;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Performance\Lib\Handlers\ExportHandler;
use Performance\Performance;
use Phpfastcache\CacheManager;
use Phpfastcache\Core\Pool\ExtendedCacheItemPoolInterface;
use RouteCMS\Cache\DoctrineCache;
use RouteCMS\Exceptions\ExceptionViewHandler;
use RouteCMS\Exceptions\FileExceptionHandler;
use RouteCMS\Util\InputUtil;
use Whoops\Run;

if (!defined("LOCAL_TIME")) define("LOCAL_TIME", time());
if (!defined("MAX_COOKIE_TIME")) define("MAX_COOKIE_TIME", 60 * 60 * 24 * 365);
if (!defined("CURRENT_URI"))
	define("CURRENT_URI", parse_url(InputUtil::server("REQUEST_URI", "string", ""), PHP_URL_PATH));

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
 */
class RouteCMS
{

	use Singleton;

	/**
	 * @var EntityManager
	 */
	private $database;

	/**
	 * @var ExtendedCacheItemPoolInterface
	 */
	private $cache;

	/**
	 * Load system
	 */
	public function load()
	{
		Performance::point("Core@load");
		Performance::point("Core@loadDatabase");
		/** @noinspection PhpIncludeInspection */
		$dbConf = include GLOBAL_DIR . "/config/db.php";
		//init database
		$config = Setup::createAnnotationMetadataConfiguration([GLOBAL_DIR . "model"], true, null, DoctrineCache::instance(), false);
		$this->database = EntityManager::create(array_merge([
			'charset'   => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix'    => '',
		], $dbConf), $config);
		if ($dbConf["update"]) {
			$tool = new SchemaTool($this->database);
			$tool->updateSchema($this->database->getMetadataFactory()->getAllMetadata(), false);
		}
		//close database Core@loadDatabase
		Performance::finish();

		//close database Core@load
		Performance::finish();
	}

	/**
	 * @return ExtendedCacheItemPoolInterface
	 */
	public function getCache(): ExtendedCacheItemPoolInterface
	{
		return $this->cache;
	}

	/**
	 * Return the database manager
	 *
	 * @return EntityManager
	 */
	public function getDatabase(): EntityManager
	{
		return $this->database;
	}

	/**
	 * Handle the local request
	 */
	public function handle()
	{
		Performance::finish();
		$performance = Performance::export();
		/** @var ExportHandler $performance */
		//TODO show this current page
		exit;
	}


	/**
	 * Initialize the Core
	 */
	protected function init()
	{
		Performance::point("Core@init");
		//init exception and error handler
		$whoops = new Run();
		$whoops->pushHandler(new ExceptionViewHandler());
		$whoops->pushHandler(new FileExceptionHandler());
		$whoops->register();

		//load annotations before
		AnnotationReader::addGlobalIgnoredName("mixin");
		Type::addType('ip', IpType::class);
		define("DOMAIN_HTTPS", InputUtil::server("HTTPS", "string", "off"));
		define("IS_POST", InputUtil::isPost());
		//init cache handler
		/** @noinspection PhpIncludeInspection */
		$config = include GLOBAL_DIR . "/config/cache.php";
		if ($config["driver"] == "Files") {
			$config["config"]["path"] = GLOBAL_DIR . (!empty($config["config"]["path"]) ? $config["config"]["path"] : "/caches/");
		}
		$this->cache = CacheManager::getInstance($config["driver"], $config["config"]);
		Performance::finish();
	}
}