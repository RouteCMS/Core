<?php
declare(strict_types=1);

namespace RouteCMS\Core;

use RouteCMS\Event\EventHandler;
use RouteCMS\Util\HeaderUtil;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class LinkHandler
{

	use Singleton;

	/**
	 * Return an generated link for an image
	 *
	 * @param string $path
	 * @param bool   $admin
	 *
	 * @return string
	 */
	public function imageLink(string $path, $admin = false): string
	{
		return $this->buildLink([
			"path"  => $path,
			"admin" => $admin,
			"image" => true
		]);
	}

	/**
	 * Generate a link
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function buildLink(array $args = []): string
	{
		$link = HeaderUtil::createLink("", (isset($args["admin"]) && $args["admin"] == true));
		$complete = false;
		$param = [
			"link"     => &$link,
			"args"     => $args,
			"complete" => &$complete
		];
		EventHandler::instance()->call("beforeBuildLink", $this, $param);

		if (!$complete) {
			if (isset($args["image"]) && $args["image"] === true) {
				$link .= "images/";
			}
			//TODO dynamic link generation for objects and more
			if (!empty($args["path"])) $link .= $args["path"];
		}
		EventHandler::instance()->call("afterBuildLink", $this, $param);

		return $link;
	}
}