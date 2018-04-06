<?php
declare(strict_types=1);
namespace RouteCMS\Model\User;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Model\Interfaces\IDInterface;
use RouteCMS\Model\Interfaces\NameInterface;
use RouteCMS\Model\Interfaces\TextInterface;


/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *                
 * @ORM\Entity
 * @ORM\Cache
 * @ModelCache
 */
class Group
{
	use IDInterface;
	use NameInterface;
	use TextInterface;
}