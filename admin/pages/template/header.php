<?php
declare(strict_types=1);
/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @var \RouteCMS\Controller\BaseController $this
 */
global $lng;

//Compile style files
use RouteCMS\Compiler\AdminStyleHandler;

AdminStyleHandler::instance()->compile();
?>
<!doctype html>
<html lang="<?php echo $lng->getCode() ?>">
    <head>
        <base href="http<?php echo(DOMAIN_HTTPS ? "s" : "") ?>://<?php echo DOMAIN . "/" . DOMAIN_PATH ?>/admin"/>
        <meta charset="utf-8"/>
        <title><?php pr($this->title) ?> - RouteCMS</title>
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
		<?php foreach (AdminStyleHandler::instance()->getStyle() as $css) { ?>
            <link rel="stylesheet" href="<?php css(str_replace(".scss", DEV_MODE ? ".css" : ".min.css", $css), true) ?>"/>
		<?php } ?>
		<?php inline("head@header") ?>
    </head>
<body <?php if (!empty($this->uniqueBodyId)) echo 'id="' . $this->uniqueBodyId . '"'; ?>>
<?php inline("afterBody@header") ?>