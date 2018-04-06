<?php
/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */

use Phpfastcache\Drivers\Files\Config;

return [
	"driver" => "Files", //Files cache driver only for testing
	"config" => new Config([
		"ignoreSymfonyNotice" => true,
		'path'                => "/caches/",
	])
];