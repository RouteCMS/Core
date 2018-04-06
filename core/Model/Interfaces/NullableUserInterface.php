<?php

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Model\User\User;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
trait NullableUserInterface
{

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="userID", referencedColumnName="id", nullable=true, onDelete="SET NULL")
	 *
	 * @var User|null
	 */
	protected $user;

	/**
	 * @return null|User
	 */
	public function getUser(): ?User
	{
		return $this->user;
	}

	/**
	 * @param null|User $user
	 */
	public function setUser(?User $user): void
	{
		$this->user = $user;
	}

}