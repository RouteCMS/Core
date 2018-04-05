<?php
/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */

use Phpfastcache\Drivers\Files\Config;

return [
	"driver" => "Files", //Files cache driver only for testing
	"config" => new Config([
		"ignoreSymfonyNotice" => true,
		'path'                => GLOBAL_DIR."/caches/",
	])
];