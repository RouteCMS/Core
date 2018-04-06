<?php
declare(strict_types=1);

namespace RouteCMS\Model\Extension;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Model\Interfaces\IDInterface;
use RouteCMS\Model\Interfaces\NameInterface;
use RouteCMS\Model\Interfaces\TextInterface;
use RouteCMS\Model\Interfaces\TimeInterface;
use RouteCMS\Model\Interfaces\VersionInterface;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 * @ModelCache
 */
class Extension
{

	use IDInterface;
	use TimeInterface;
	use NameInterface;
	use TextInterface;
	use VersionInterface;

	/**
	 * @ORM\Column(type="string")
	 *
	 * @var string
	 */
	protected $author = "";

	/**
	 * @ORM\Column(type="string")
	 *
	 * @var string
	 */
	protected $website = "";
}