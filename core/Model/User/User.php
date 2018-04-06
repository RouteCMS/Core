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
	 * @ORM\ManyToMany(targetEntity="Group")
	 * @ORM\JoinTable(
	 *     joinColumns={@ORM\JoinColumn(referencedColumnName="id",unique=true)},
	 *      inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="id", unique=true)}
	 *     )
	 */
	protected $groups;

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
}