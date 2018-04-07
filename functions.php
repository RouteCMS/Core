<?php
/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *                
 * File to define simple functions to make it easy print text, links and more
 */

use RouteCMS\Model\Language\Language;

/**
 * Return the value from the language item
 *
 * @param string        $name
 *
 * @param null|Language $language
 *
 * @return string
 */
function txt(string $name, ?Language $language = null): string
{
	global $lng;

	return $language !== null ? $language->getValue($name) : $lng->getValue($name);
}

/**
 * Print an language item
 *
 * @param string        $name
 *
 * @param null|Language $language
 */
function pr(string $name, ?Language $language = null): void
{
	echo txt($name, $language);
}

/**
 * Print an image link
 *
 * @param string $path
 * @param bool   $admin
 *
 * @return void
 */
function img(string $path, $admin = false): void
{
	global $link;
	echo $link->imageLink($path, $admin);
}
/**
 * Print an style(css) link
 *
 * @param string $path
 * @param bool   $admin
 *
 * @return void
 */
function css(string $path, $admin = false): void
{
	global $link;
	echo $link->styleLink($path, $admin);
}

/**
 * Print an JavaScript(js) link
 *
 * @param string $path
 * @param bool   $admin
 *
 * @return void
 */
function js(string $path, $admin = false): void
{
	global $link;
	echo $link->jsLink($path, $admin);
}
