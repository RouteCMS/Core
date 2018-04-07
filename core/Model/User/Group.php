<?php
declare(strict_types=1);

namespace RouteCMS\Model\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Model\Interfaces\IDInterface;
use RouteCMS\Model\Interfaces\NameInterface;
use RouteCMS\Model\Interfaces\TextInterface;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 * @ModelCache
 * @ORM\Table(name="groups")
 */
class Group
{

	use IDInterface;
	use NameInterface;
	use TextInterface;

	/**
	 * @ORM\OneToMany(targetEntity="GroupPermissionValues", mappedBy="group", cascade={"persist"})
	 * 
	 * @var ArrayCollection
	 */
	protected $permissions;

	/**
	 * Group constructor.
	 */
	public function __construct()
	{
		$this->permissions = new ArrayCollection();
	}

	/**
	 * @return ArrayCollection
	 */
	public function getPermissions(): ArrayCollection
	{
		return $this->permissions;
	}

	/**
	 * @param ArrayCollection $permissions
	 */
	public function setPermissions(ArrayCollection $permissions): void
	{
		$this->permissions = $permissions;
	}
	
}