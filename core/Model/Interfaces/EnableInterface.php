<?php

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
trait EnableInterface
{

	/**
	 * @ORM\Column(type="boolean")
	 *
	 * @var bool
	 */
	protected $enable = true;

	/**
	 * @return bool
	 */
	public function isEnable(): bool
	{
		return $this->enable;
	}

	/**
	 * @param bool $enable
	 */
	public function setEnable(bool $enable)
	{
		$this->enable = $enable;
	}
}