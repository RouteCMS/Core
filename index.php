<?php
/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
 */

use RouteCMS\RouteCMS;

if (!defined('GLOBAL_DIR')) {
	define('GLOBAL_DIR', str_replace('\\', '/', dirname(__FILE__)) . '/');
}

/** @noinspection PhpIncludeInspection */
include GLOBAL_DIR . "config/config.php";
require_once "vendor/autoload.php";
$cms = RouteCMS::instance();
$cms->load();