<?php

namespace RouteCMS\Model\Interfaces;

use Darsyn\IP\IP;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
trait IpAddressInterface
{

	/**
	 * @ORM\Column(type="ip", nullable=false)
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
	public function setIpAddress(IP $ipAddress)
	{
		$this->ipAddress = $ipAddress;
	}

}