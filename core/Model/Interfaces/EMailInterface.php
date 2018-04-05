<?php

namespace RouteCMS\Model\Interfaces;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author        Olaf Braun
 * @copyright     2013-2017 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
trait EMailInterface
{

	/**
	 * @ORM\Column(type="string")
	 *
	 * @var string
	 */
	protected $email = "";

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email)
	{
		$this->email = $email;
	}
}