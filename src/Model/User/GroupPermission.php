<?php
declare(strict_types=1);

namespace RouteCMS\Model\User;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Model\Interfaces\IDNameInterface;
use RouteCMS\Model\Interfaces\NameInterface;
use RouteCMS\Model\Interfaces\TextInterface;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 */
class GroupPermission
{

	use IDNameInterface;
	use NameInterface;
	use TextInterface;

	/**
	 * @ORM\Column(type="text", nullable=false, options={"default" : ""})
	 *
	 * @var string
	 */
	protected $defaultValue = "";

	/**
	 * @return string
	 */
	public function getDefaultValue(): string
	{
		return $this->defaultValue;
	}

	/**
	 * @param string $defaultValue
	 */
	public function setDefaultValue(string $defaultValue): void
	{
		$this->defaultValue = $defaultValue;
	}
}