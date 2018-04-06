<?php

namespace RouteCMS\Model\User;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Annotations\Database\ModelCache;
use RouteCMS\Model\Interfaces\IpAddressInterface;
use RouteCMS\Model\Interfaces\NullableUserInterface;
use RouteCMS\Model\Interfaces\TimeInterface;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\Cache
 * @ModelCache
 */
class Session
{

	use TimeInterface;
	use IpAddressInterface;
	use NullableUserInterface;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="string", unique=true)
	 *
	 * @var string
	 */
	protected $token;

	/**
	 * @ORM\Column(type="string")
	 *
	 * @var string
	 */
	protected $userAgent;

	/**
	 * @ORM\Column(type="string")
	 *
	 * @var string
	 */
	protected $requestUri;


	/**
	 * @ORM\Column(type="array", nullable=true)
	 *
	 * @var array|null
	 */
	protected $data;

	/**
	 * @ORM\Column(type="integer")
	 *
	 * @var integer
	 */
	protected $lastAction;

	/**
	 * @return string
	 */
	public function getToken(): string
	{
		return $this->token;
	}

	/**
	 * @param mixed $token
	 */
	public function setToken($token): void
	{
		$this->token = $token;
	}

	/**
	 * @return string
	 */
	public function getUserAgent(): string
	{
		return $this->userAgent;
	}

	/**
	 * @param string $userAgent
	 */
	public function setUserAgent(string $userAgent)
	{
		$this->userAgent = $userAgent;
	}

	/**
	 * @return string
	 */
	public function getRequestUri(): string
	{
		return $this->requestUri;
	}

	/**
	 * @param string $requestUri
	 */
	public function setRequestUri(string $requestUri): void
	{
		$this->requestUri = $requestUri;
	}

	/**
	 * @return array|null
	 */
	public function getData(): ?array
	{
		return $this->data;
	}

	/**
	 * @param array|null $data
	 */
	public function setData($data): void
	{
		$this->data = $data;
	}

	/**
	 * @return int
	 */
	public function getLastAction(): int
	{
		return $this->lastAction;
	}

	/**
	 * @param int $lastAction
	 */
	public function setLastAction(int $lastAction): void
	{
		$this->lastAction = $lastAction;
	}
}