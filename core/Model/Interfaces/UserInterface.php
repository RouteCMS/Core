<?php

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Model\User\User;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       Braun-Development.de License <https://www.braun-development.de/lizenz.html>
 */
trait UserInterface
{

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="userID", referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 *
	 * @var User
	 */
	protected $user;

	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}

	/**
	 * @param User $user
	 */
	public function setUser(User $user): void
	{
		$this->user = $user;
	}

}