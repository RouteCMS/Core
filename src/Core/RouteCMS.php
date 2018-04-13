<?php
declare(strict_types=1);

namespace RouteCMS\Core;

use Darsyn\IP\Doctrine\IpType;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Phpfastcache\CacheManager;
use Phpfastcache\Core\Pool\ExtendedCacheItemPoolInterface;
use RouteCMS\Annotations\Database\EnumColumn;
use RouteCMS\Cache\DoctrineCache;
use RouteCMS\Exceptions\ExceptionViewHandler;
use RouteCMS\Exceptions\FileExceptionHandler;
use RouteCMS\Exceptions\SystemException;
use RouteCMS\Model\Language\Language;
use RouteCMS\Util\InputUtil;
use Whoops\Run;

if (!defined("LOCAL_TIME")) define("LOCAL_TIME", time());
if (!defined("MAX_COOKIE_TIME")) define("MAX_COOKIE_TIME", 60 * 60 * 24 * 365);
if (!defined("CURRENT_URI"))
	define("CURRENT_URI", parse_url(str_replace("index.php?/", "", InputUtil::server("REQUEST_URI", "string", "")), PHP_URL_PATH));

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
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
	 * @var Language
	 */
	private $language;

	/**
	 * Load system
	 */
	public function load(): void
	{
		EventHandler::instance()->call("beforeLoad", $this);
		/** @noinspection PhpIncludeInspection */
		$dbConf = include GLOBAL_DIR . "/config/db.php";
		//init database
		$config = Setup::createAnnotationMetadataConfiguration([GLOBAL_DIR . "src/Model"], DEV_MODE, null, DoctrineCache::instance(), false);
		$this->database = EntityManager::create(array_merge([
			'charset'   => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix'    => '',
		], $dbConf), $config);
		AnnotationHandler::instance()->doCall(EnumColumn::class, GLOBAL_DIR . "src/", function ($className, $annotation) {
			/** @var EnumColumn $annotation */
			Type::addType($annotation->name, $className);
		});
		if ($dbConf["update"]) {
			$tool = new SchemaTool($this->database);
			$tool->updateSchema($this->database->getMetadataFactory()->getAllMetadata(), false);
		}
		EventHandler::instance()->call("afterLoadDatabase", $this);
		//Init controller system
		RouteHandler::instance();
		//define language
		$this->language = $this->database->getRepository(Language::class)->findOneBy([
			"default" => true
		], null, 1);
		if($this->language === null) throw new SystemException("Default language could´t find.");

		EventHandler::instance()->call("afterLoad", $this);
	}

	/**
	 * @return Language
	 */
	public function getLanguage(): Language
	{
		return $this->language;
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
	public function handleRequest(): void
	{
		RouteHandler::instance()->handle();
		//TODO show this current page
		EventHandler::instance()->call("exit", $this);
		exit;
	}

	/**
	 * Initialize the RouteCMS
	 */
	protected function init(): void
	{
		//init exception and error handler
		$whoops = new Run();
		$whoops->pushHandler(new ExceptionViewHandler());
		$whoops->pushHandler(new FileExceptionHandler());
		$whoops->register();

		//add ignore annotations before
		AnnotationReader::addGlobalIgnoredName("mixin");
		AnnotationReader::addGlobalIgnoredName("Source");
		Type::addType('ip', IpType::class);
		define("DOMAIN_HTTPS", InputUtil::server("HTTPS", "string", "off") != "off");
		define("IS_POST", InputUtil::isPost());
		//init cache handler
		/** @noinspection PhpIncludeInspection */
		$config = include GLOBAL_DIR . "/config/cache.php";
		if ($config["driver"] == "Files") {
			$config["config"]["path"] = GLOBAL_DIR . (!empty($config["config"]["path"]) ? $config["config"]["path"] : "/caches/");
		}
		$this->cache = CacheManager::getInstance($config["driver"], $config["config"]);
	}
}