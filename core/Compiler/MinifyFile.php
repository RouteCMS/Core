<?php
declare(strict_types=1);

namespace RouteCMS\Compiler;

use RouteCMS\Util\InputUtil;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
abstract class MinifyFile
{

	/**
	 * @var string
	 */
	protected $protocol = "";

	/**
	 * @var string
	 */
	protected $in;

	/**
	 * @var string
	 */
	protected $source;

	/**
	 * @var string
	 */
	protected $sourceOut;

	/**
	 * @var string
	 */
	protected $out;

	/**
	 * @var string
	 */
	protected $contentType = "text/plain";

	/**
	 * @var integer
	 */
	protected $expires = 31536000;

	/**
	 * @var string
	 */
	protected $emptyBody = "/* File not found */\n";

	/**
	 * MinifyFile constructor.
	 *
	 * @param string $file
	 */
	public function __construct(string $file)
	{
		$this->protocol = InputUtil::server("SERVER_PROTOCOL", "string", "HTTP/1.0");
		if (empty($file)) {
			throw new \InvalidArgumentException('The $file variable is empty');
		}
		$this->loadFile($file);
	}

	/**
	 * Load current given file
	 *
	 * @param string $file
	 */
	abstract protected function loadFile(string $file): void;

	/**
	 * Minify file
	 */
	public function minifyFile(): void
	{
		$this->doCompileSource();
		if ($this->needMinify()) {
			$this->doMinifyFile();
		}
	}

	/**
	 * Compile the source if need
	 */
	protected function doCompileSource(): void
	{
		//do nothing by default
	}

	/**
	 * @return bool
	 */
	protected function needMinify(): bool
	{
		if (!file_exists($this->out)) return true;
		$mtimeOut = filemtime($this->out);
		$mtimeIn = filemtime($this->in);

		return $mtimeOut < $mtimeIn;
	}

	/**
	 * Do the minify file
	 *
	 * @return string
	 */
	abstract protected function doMinifyFile(): string;
}