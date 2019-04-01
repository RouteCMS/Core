<?php
declare(strict_types=1);

namespace RouteCMS\Model\Language;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Model\Interfaces\EnableInterface;
use RouteCMS\Model\Interfaces\IDInterface;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 * @ModelCache
 */
class Language
{

	use IDInterface;
	use EnableInterface;

	/**
	 * @ORM\Column(type="string", unique=true, length=5)
	 *
	 * @var string
	 */
	protected $code;

	/**
	 * @ORM\Column(name="isDefault", type="boolean", unique=true)
	 *
	 * @var bool
	 */
	protected $default;

	/**
	 * @ORM\Column(type="string", unique=true, length=191)
	 *
	 * @var string
	 */
	protected $country;

	/**
	 * @ORM\Column(type="string", unique=true, length=191)
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * @return string
	 */
	public function getCode(): string
	{
		return $this->code;
	}

	/**
	 * @param string $code
	 */
	public function setCode(string $code): void
	{
		$this->code = $code;
	}

	/**
	 * @return bool
	 */
	public function isDefault(): bool
	{
		return $this->default;
	}

	/**
	 * @param bool $default
	 */
	public function setDefault(bool $default): void
	{
		$this->default = $default;
	}

	/**
	 * @return string
	 */
	public function getCountry(): string
	{
		return $this->country;
	}

	/**
	 * @param string $country
	 */
	public function setCountry(string $country): void
	{
		$this->country = $country;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * Return the content of a variable
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public function getValue(string $name): string
	{
		//TODO get value and cache them
		return $name;
	}
}