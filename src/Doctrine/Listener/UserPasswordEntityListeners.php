<?php
declare(strict_types=1);

namespace RouteCMS\Doctrine\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Model\User\User;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class UserPasswordEntityListeners
{

	/**
	 * @param User               $user
	 * @param LifecycleEventArgs $event
	 *
	 * @ORM\PrePersist
	 */
	public function prePersistHandler(User $user, LifecycleEventArgs $event)
	{
		if (!empty($user->getPassword())) {
			$hash = self::hashPassword($user->getPassword());
			$user->setPassword($hash);
		}
	}

	/**
	 * Hash an password and return it
	 *
	 * @param string $password
	 *
	 * @return string
	 */
	public static function hashPassword(string $password): string
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	/**
	 * @param User               $user
	 * @param PreUpdateEventArgs $event
	 *
	 * @ORM\PreUpdate
	 */
	public function preUpdateHandler(User $user, PreUpdateEventArgs $event)
	{
		if ($event->hasChangedField("password") && !empty($user->getPassword())) {
			$user->setPassword(self::hashPassword($user->getPassword()));
		}
	}
}