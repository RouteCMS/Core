<?php
/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
declare(strict_types=1);
error_reporting(E_ALL);

use Doctrine\ORM\EntityManager;
use RouteCMS\Core\RouteCMS;

if (!defined('GLOBAL_DIR')) {
	define('GLOBAL_DIR', str_replace('\\', '/', dirname(__FILE__)) . '/');
}

/** @noinspection PhpIncludeInspection */
include GLOBAL_DIR . "config/config.php";
require_once "vendor/autoload.php";
$cms = RouteCMS::instance();
$cms->load();
$cms->handleRequest();

//define some simple functions
/**
 * Return the database object
 * 
 * @return EntityManager
 */
function getDatabase() : EntityManager{
	return RouteCMS::instance()->getDatabase();
}