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
class JavaScriptMinifyFile extends MinifyFile
{
	/**
	 * @inheritdoc
	 */
	protected $contentType = "text/javascript";

	/**
	 * @inheritdoc
	 */
	protected function loadFile(string $file): void
	{
		if (StringUtil::endsWith($file, ".js") && file_exists($file)) {
			$this->in = $file;
			$this->out = str_replace(".js", ".min.js", $file);
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