<?php
declare(strict_types=1);

namespace RouteCMS\Doctrine;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class ClassAnnotation
{

	/**
	 * @var null|array
	 */
	private $classAnnotations = null;

	/**
	 * @var null|array
	 */
	private $methodAnnotations = null;

	/**
	 * @var null|array
	 */
	private $propertyAnnotations = null;

	/**
	 * @var string
	 */
	private $className = "";

	/**
	 * ClassAnnotation constructor.
	 *
	 * @param string     $className
	 * @param array|null $classAnnotations
	 * @param array|null $methodAnnotations
	 * @param array|null $propertyAnnotations
	 */
	public function __construct(string $className, ?array $classAnnotations, ?array $methodAnnotations, ?array $propertyAnnotations)
	{
		$this->className = $className;
		$this->classAnnotations = $classAnnotations;
		$this->methodAnnotations = $methodAnnotations;
		$this->propertyAnnotations = $propertyAnnotations;
	}

	/**
	 * @return array|null
	 */
	public function getClassAnnotations(): ?array
	{
		return $this->classAnnotations;
	}

	/**
	 * @return array|null
	 */
	public function getMethodAnnotations(): ?array
	{
		return $this->methodAnnotations;
	}

	/**
	 * @return string
	 */
	public function getClassName(): string
	{
		return $this->className;
	}

	/**
	 * @return array|null
	 */
	public function getPropertyAnnotations(): ?array
	{
		return $this->propertyAnnotations;
	}
}