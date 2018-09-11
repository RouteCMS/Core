<?php
declare(strict_types=1);

namespace RouteCMS\Controller\Parser;

use Phramz\Doctrine\Annotation\Scanner\FileInspector;
use RouteCMS\Core\Singleton;
use RouteCMS\Exceptions\SystemException;
use Symfony\Component\Finder\Finder;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class FormParserHandler
{

	use Singleton;

	/**
	 * @var string[]
	 */
	protected $parser = [];

	/**
	 * Register a new parser
	 *
	 * @param string $name
	 * @param string $namespace
	 */
	public function registerParser(string $name, string $namespace): void
	{
		$name = ucfirst($name);
		if (isset($this->parser[$name])) {
			throw new SystemException("Form parser '$name' already registered!");
		}
		$this->parser[$name] = $namespace;
	}

	/**
	 * Return a form parser
	 *
	 * @param string $name
	 * @param        $default
	 * @param array  $options
	 *
	 * @return FormParser
	 * @throws SystemException
	 */
	public function getParser(string $name, $default, array $options): FormParser
	{
		$name = ucfirst($name);
		if (!isset($this->parser[$name])) {
			throw new SystemException("Form parser of type '$name' couldn't found!");
		}

		return new $this->parser[$name]($name, $default, $options);
	}

	/**
	 * @inheritDoc
	 */
	protected function init(): void
	{ 
		$parser = [];
		$finder = (new Finder())
			->files()
			->name('*FormParser.php')
			->in(__DIR__)
			->filter(
				function (\SplFileInfo $file) use (&$parser) {
					$fileInspector = new FileInspector($file->getPathname());

					$reflection = new \ReflectionClass($fileInspector->getFullQualifiedClassname());
					if ($reflection->isInstantiable() && $reflection->implementsInterface(FormParser::class)) {
						$parser[str_replace("FormParser", "", $fileInspector->getClassname())] = $fileInspector->getFullQualifiedClassname();

						return true;
					}

					return false;
				}
			);
		$finder->count(); //Load default form parser
		$this->parser = $parser;
	}

}