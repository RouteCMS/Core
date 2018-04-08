<?php
declare(strict_types=1);

namespace RouteCMS\Compiler;

use Leafo\ScssPhp\Compiler;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class StyleCompiler extends AbstractFileCompiler
{

	/**
	 * @var Compiler
	 */
	protected $scss;

	/**
	 * Constructor
	 *
	 * @param string $in
	 * @param string $out
	 * @param string $path
	 */
	public function __construct(string $in, string $out, string $path)
	{
		parent::__construct($in, $out);
		$this->scss = new Compiler();
		$this->scss->setImportPaths($path);
	}

	/**
	 * @return Compiler
	 */
	public function getScss(): Compiler
	{
		return $this->scss;
	}

	/**
	 * @inheritdoc
	 */
	public function compileFile(): void
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
	 * @inheritdoc
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