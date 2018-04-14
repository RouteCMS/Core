<?php
declare(strict_types=1);
error_reporting(E_ALL);

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */

use RouteCMS\Core\EventHandler;
use RouteCMS\Core\RouteCMS;

if (!defined('GLOBAL_DIR')) {
	define('GLOBAL_DIR', str_replace('\\', '/', dirname(__FILE__)) . '/../');
}
include "../config/config.php";
require_once "../vendor/autoload.php";
/**
 * @global RouteCMS     $cms
 * @global EventHandler $event
 */
global $cms, $event, $session;
$event = EventHandler::instance();
$cms = RouteCMS::instance();
include "../functions.php";