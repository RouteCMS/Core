<?php
declare(strict_types=1);

namespace RouteCMS\Model\User;

use Doctrine\ORM\Mapping as ORM;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 */
class GroupPermissionValues
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\ManyToOne(targetEntity="Group", cascade={"persist"})
	 * @ORM\JoinColumn(referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 *
	 * @var Group
	 */
	protected $group;
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\ManyToOne(targetEntity="GroupPermission", cascade={"persist"})
	 * @ORM\JoinColumn(referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 *
	 * @var GroupPermission
	 */
	protected $permission;

	/**
	 * @ORM\Column(type="text", nullable=false, options={"default" : ""})
	 * 
	 * @var string 
	 */
	protected $value = "";

	/**
	 * @return Group
	 */
	public function getGroup(): Group
	{
		return $this->group;
	}

	/**
	 * @param Group $group
	 */
	public function setGroup(Group $group): void
	{
		$this->group = $group;
	}

	/**
	 * @return GroupPermission
	 */
	public function getPermission(): GroupPermission
	{
		return $this->permission;
	}

	/**
	 * @param GroupPermission $permission
	 */
	public function setPermission(GroupPermission $permission): void
	{
		$this->permission = $permission;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue(string $value): void
	{
		$this->value = $value;
	}

}