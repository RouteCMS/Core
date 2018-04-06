<?php
declare(strict_types=1);

namespace RouteCMS\Model\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Model\Interfaces\EMailInterface;
use RouteCMS\Model\Interfaces\IDInterface;
use RouteCMS\Model\Interfaces\IpAddressInterface;
use RouteCMS\Model\Interfaces\TimeInterface;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 * @ModelCache
 */
class User
{

	use IDInterface;
	use EMailInterface;
	use TimeInterface;
	use IpAddressInterface;

	/**
	 * @ORM\Column(type="string", unique=true)
	 *
	 * @var string
	 */
	protected $email = "";

	/**
	 * @ORM\ManyToMany(targetEntity="Group")
	 * @ORM\JoinTable(
	 *     joinColumns={@ORM\JoinColumn(referencedColumnName="id",unique=true)},
	 *      inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="id", unique=true)}
	 *     )
	 */
	protected $groups;

	/**
	 * @ORM\Column(type="string")
	 *
	 * @var string
	 */
	protected $password = "";

	/**
	 * @ORM\Column(type="boolean")
	 *
	 * @var bool
	 */
	protected $banned = false;

	/**
	 * @inheritDoc
	 */
	public function __construct()
	{
		$this->groups = new ArrayCollection();
	}

	/**
	 * @return ArrayCollection
	 */
	public function getGroups(): ArrayCollection
	{
		return $this->groups;
	}

	/**
	 * @param ArrayCollection $groups
	 */
	public function setGroups(ArrayCollection $groups): void
	{
		$this->groups = $groups;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	/**
	 * @return bool
	 */
	public function isBanned(): bool
	{
		return $this->banned;
	}

	/**
	 * @param bool $banned
	 */
	public function setBanned(bool $banned): void
	{
		$this->banned = $banned;
	}
}