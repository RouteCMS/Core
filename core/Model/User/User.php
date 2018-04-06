<?php

namespace RouteCMS\Model\User;

use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Model\Interfaces\EMailInterface;
use RouteCMS\Model\Interfaces\IDInterface;
use RouteCMS\Model\Interfaces\IpAddressInterface;
use RouteCMS\Model\Interfaces\TimeInterface;
use Doctrine\ORM\Mapping as ORM;

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
}