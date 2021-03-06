<?php
declare(strict_types=1);

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
trait TimeInterface
{

	/**
	 * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
	 *
	 * @var integer
	 */
	protected $time = LOCAL_TIME;

	/**
	 * @return int
	 */
	public function getTime(): int
	{
		return $this->time;
	}

	/**
	 * @param int $time
	 */
	public function setTime(int $time): void
	{
		$this->time = $time;
	}
}