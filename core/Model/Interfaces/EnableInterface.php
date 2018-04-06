<?php
declare(strict_types=1);

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
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
	public function setEnable(bool $enable): void
	{
		$this->enable = $enable;
	}
}