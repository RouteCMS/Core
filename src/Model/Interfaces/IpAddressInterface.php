<?php
declare(strict_types=1);

namespace RouteCMS\Model\Interfaces;

use Darsyn\IP\IP;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
trait IpAddressInterface
{

	/**
	 * @ORM\Column(type="ip", nullable=true)
	 *
	 * @var IP
	 */
	protected $ipAddress;

	/**
	 * @return IP
	 */
	public function getIpAddress(): IP
	{
		return $this->ipAddress;
	}

	/**
	 * @param IP $ipAddress
	 */
	public function setIpAddress(IP $ipAddress): void
	{
		$this->ipAddress = $ipAddress;
	}

}