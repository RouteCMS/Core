<?php
/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
declare(strict_types=1);
error_reporting(E_ALL); //TODO set error reporting by dev level

use Doctrine\ORM\EntityManager;
use RouteCMS\Core\LinkHandler;
use RouteCMS\Core\RouteCMS;
use RouteCMS\Core\EventHandler;
use RouteCMS\Model\Language\Language;
use RouteCMS\Core\SessionHandler;
use RouteCMS\Plugin\PluginHandler;

if (!defined('GLOBAL_DIR')) {
	define('GLOBAL_DIR', str_replace('\\', '/', dirname(__FILE__)) . '/');
}
require_once "vendor/autoload.php";
/** @noinspection PhpIncludeInspection */
include "config/config.php";
/**
 * @global RouteCMS       $cms
 * @global EventHandler   $event
 * @global Language       $lng
 * @global EntityManager  $db
 * @global LinkHandler    $link
 * @global SessionHandler $session
 * @global PluginHandler $plugin
 */
global $cms, $event, $lng, $db, $link, $session, $plugin;
$link = LinkHandler::instance();
$event = EventHandler::instance();
$cms = RouteCMS::instance();
$plugin = PluginHandler::instance();
$plugin->enablePlugins(); //enable plugins first
$cms->load();
include "functions.php";
//define global variable
$lng = $cms->getLanguage();
$db = $cms->getDatabase();
//init session
$session = SessionHandler::instance();

//handle the request and print content
$cms->handleRequest();