<?php

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
trait TimeInterface
{

	/**
	 * @ORM\Column(type="integer", nullable=false)
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
	public function setTime(int $time)
	{
		$this->time = $time;
	}
}