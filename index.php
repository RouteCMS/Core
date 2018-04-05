<?php
/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */

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

//define some simple functions
/**
 * Return the database object
 * 
 * @return EntityManager
 */
function getDatabase() : EntityManager{
	return RouteCMS::instance()->getDatabase();
}