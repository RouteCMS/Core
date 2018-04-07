<?php
declare(strict_types=1);

namespace RouteCMS\Compiler;

use MatthiasMullie\Minify\JS;
use RouteCMS\Util\StringUtil;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class JavaScriptAdminMinifyFile extends MinifyFile
{

	const PATH = GLOBAL_DIR . "admin/js/";

	/**
	 * @inheritdoc
	 */
	protected $contentType = "text/javascript";

	/**
	 * @inheritdoc
	 */
	protected function loadFile(string $file): void
	{
		if (StringUtil::endsWith($file, ".js") && file_exists(self::PATH . $file)) {
			$this->in = self::PATH . $file;
			$this->out = self::PATH . str_replace(".js", ".min.js", $file);
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function doMinifyFile(): string
	{
		$minifier = new JS($this->in);

		return $minifier->minify($this->out);
	}
}