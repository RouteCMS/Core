<?php
/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @var \RouteCMS\Controller\BaseController $this
 */
//Compile style files
use RouteCMS\Style\StyleHandler;

StyleHandler::instance()->compile(true);
?>
<!doctype html>
<html lang="en"><!-- TODO load language code dynamic -->
<head>
    <base href="http<?php echo(DOMAIN_HTTPS ? "s" : "") ?>://<?php echo DOMAIN . "/" . DOMAIN_PATH ?>/admin"/>
    <meta charset="utf-8"/>
    <title><?php pr($this->title) ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="apple-touch-icon" sizes="57x57" href="<?php img("touch-icon/apple-icon-57x57.png", true) ?>"/>
    <link rel="apple-touch-icon" sizes="60x60" href="<?php img("touch-icon/apple-icon-60x60.png", true) ?>"/>
    <link rel="apple-touch-icon" sizes="72x72" href="<?php img("touch-icon/apple-icon-72x72.png", true) ?>"/>
    <link rel="apple-touch-icon" sizes="76x76" href="<?php img("touch-icon/apple-icon-76x76.png", true) ?>"/>
    <link rel="apple-touch-icon" sizes="114x114" href="<?php img("touch-icon/apple-icon-114x114.png", true) ?>"/>
    <link rel="apple-touch-icon" sizes="120x120" href="<?php img("touch-icon/apple-icon-120x120.png", true) ?>"/>
    <link rel="apple-touch-icon" sizes="144x144" href="<?php img("touch-icon/apple-icon-144x144.png", true) ?>"/>
    <link rel="apple-touch-icon" sizes="152x152" href="<?php img("touch-icon/apple-icon-152x152.png", true) ?>"/>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php img("touch-icon/apple-icon-180x180.png", true) ?>"/>
    <link rel="icon" type="image/png" sizes="192x192" href="<?php img("touch-icon/android-icon-192x192.png", true) ?>"/>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php img("touch-icon/favicon-32x32.png", true) ?>"/>
    <link rel="icon" type="image/png" sizes="96x96" href="<?php img("touch-icon/favicon-96x96.png", true) ?>"/>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php img("touch-icon/favicon-16x16.png", true) ?>"/>
    <link rel="manifest" href="<?php img("touch-icon/manifest.json", true) ?>"/>
    <meta name="msapplication-TileColor" content="#ffffff"/>
    <meta name="msapplication-TileImage" content="<?php img("touch-icon/ms-icon-144x144.png", true) ?>"/>
    <meta name="theme-color" content="#ffffff"/>
    <link rel="stylesheet" href="<?php css("core.min.css", true) ?>"/>
    <link rel="stylesheet" href="<?php css("font-awesome.min.css", true) ?>"/>
</head>
<body>