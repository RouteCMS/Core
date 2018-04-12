<?php
declare(strict_types=1);


namespace RouteCMS\Compiler;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
abstract class AbstractFileCompiler
{

	/**
	 * @var string
	 */
	protected $in = "";

	/**
	 * @var string
	 */
	protected $out = "";

	/**
	 * File compiler constructor
	 *
	 * @param string $in
	 * @param string $out
	 */
	public function __construct(string $in, string $out)
	{
		$this->in = $in;
		$this->out = $out;
		global $event;
		$event->call("compile", $this);
	}

	/**
	 * Compile the current file
	 */
	abstract public function compileFile(): void;

	/**
	 * Determine whether file needs to be re-compiled.
	 *
	 * @return boolean True if compile required.
	 */
	public function needsCompile(): bool
	{
		if (!is_file($this->out)) {
			return true;
		}

		$mtime = filemtime($this->out);

		$metadataName = $this->metadataName();

		if (is_readable($metadataName)) {
			$metadata = unserialize(file_get_contents($metadataName));

			foreach ($metadata['imports'] as $import => $originalMtime) {
				if (!file_exists($import)) return true;

				$currentMtime = filemtime($import);

				if ($currentMtime !== $originalMtime || $currentMtime > $mtime) {
					return true;
				}
			}

			return false;
		}

		return true;
	}

	/**
	 * Get path to meta data
	 *
	 * @return string
	 */
	protected function metadataName(): string
	{
		return $this->out . '.meta';
	}
}