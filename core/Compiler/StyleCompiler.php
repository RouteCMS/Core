<?php
declare(strict_types=1);

namespace RouteCMS\Compiler;

use Leafo\ScssPhp\Compiler;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class StyleCompiler
{

	/**
	 * @var Compiler
	 */
	protected $scss;

	/**
	 * @var string
	 */
	protected $in = "";

	/**
	 * @var string
	 */
	protected $out = "";

	/**
	 * Constructor
	 *
	 * @param string $in
	 * @param string $out
	 * @param string $path
	 */
	public function __construct(string $in, string $out, string $path)
	{
		$this->in = $in;
		$this->out = $out;
		$this->scss = new Compiler();
		$this->scss->setImportPaths($path);
		global $event;
		$event->call("compile", $this);
	}

	/**
	 * @return Compiler
	 */
	public function getScss(): Compiler
	{
		return $this->scss;
	}

	/**
	 * Check if file need compiling
	 *
	 * @return bool
	 */
	public function checkedCompile(): bool
	{
		if (!is_file($this->out) || filemtime($this->in) > filemtime($this->out)) {
			$this->compileStyle();

			return true;
		}

		return false;
	}

	/**
	 * Compile the current style
	 */
	public function compileStyle(): void
	{
		$start = microtime(true);
		$css = $this->scss->compile(file_get_contents($this->in), $this->in);
		$elapsed = round((microtime(true) - $start), 4);

		$t = date('r');
		$css = "/* stylesheet compiled on $t (${elapsed}s) */\n\n" . $css;
		$etag = md5($css);

		file_put_contents($this->out, $css);
		file_put_contents(
			$this->metadataName(),
			serialize([
				'etag'    => $etag,
				'imports' => $this->scss->getParsedFiles(),
				'vars'    => crc32(serialize($this->scss->getVariables())),
			])
		);
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

	/**
	 * Determine whether .scss file needs to be re-compiled.
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

			$metaVars = crc32(serialize($this->scss->getVariables()));

			if ($metaVars !== $metadata['vars']) {
				return true;
			}

			return false;
		}

		return true;
	}
}