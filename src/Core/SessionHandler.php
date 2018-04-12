<?php
declare(strict_types=1);

namespace RouteCMS\Core;

use Darsyn\IP\IP;
use RouteCMS\Model\User\Session;
use RouteCMS\Model\User\User;
use RouteCMS\Util\InputUtil;
use RouteCMS\Util\StringUtil;
use RouteCMS\Util\UserUtil;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class SessionHandler
{

	use Singleton;

	/**
	 * @var array
	 */
	protected $data = [];

	/**
	 * @var Session
	 */
	protected $session = null;

	/**
	 * @var boolean
	 */
	protected $save = true;

	/**
	 * @var User|null
	 */
	private $user;

	/**
	 * @return null|User
	 */
	public function getUser(): ?User
	{
		return $this->user;
	}

	/**
	 * Clear the current session
	 */
	public function clear(): void
	{
		global $db;
		//remove session from database
		$db->remove($this->session);
		$db->flush();
		//reset information
		$this->user = null;
		$this->session = null;
		$this->save = false;
		$this->data = [];
	}

	/**
	 * @inheritdoc
	 */
	public function __destruct()
	{
		$this->save();
	}

	/**
	 * Save the current session to database
	 */
	public function save(): void
	{
		if ($this->save) {
			global $db;
			$this->session->setUser($this->user);
			$this->session->setData($this->data);
			$this->session->setLastAction(LOCAL_TIME);
			$db->merge($this->session);
			$db->flush();
		}
	}

	/**
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function __get(string $key)
	{
		return $this->get($key);
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 */
	public function __set(string $key, $value): void
	{
		$this->set($key, $value);
	}

	/**
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public function get(string $key, $default = null)
	{
		if (isset($this->data[$key])) {
			return $this->data[$key];
		}

		return $default;
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 */
	public function set(string $key, $value): void
	{
		$this->save = true;

		$this->data[$key] = $value;
	}

	/**
	 * @param string $key
	 */
	public function remove(string $key): void
	{
		unset($this->data[$key]);
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	function __isset(string $name): bool
	{
		return $this->exists($name);
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function exists(string $key): bool
	{
		return (isset($this->data[$key]));
	}

	/**
	 * destroy the current session
	 */
	public function destroy(): void
	{
		if ($this->session !== null) {
			global $db;
			$db->remove($this->session);
			$this->setCookie("session", "", -1);
		}
	}

	/**
	 * @param string    $key
	 * @param mixed     $value
	 * @param float|int $expire
	 */
	private function setCookie(string $key, $value, $expire = (LOCAL_TIME + MAX_COOKIE_TIME)): void
	{
		//TODO load dynamic from database the domain and path for cookies
		setcookie(COOKIE_PREFIX . $key, $value, $expire, "/".DOMAIN_PATH);
	}

	/**
	 * initialize the session handler
	 */
	protected function init(): void
	{
		global $db;
		// fetch token
		$token = InputUtil::cookie(COOKIE_PREFIX . "session", "string", null);
		if (!empty($token)) {
			$this->session = $db->getRepository(Session::class)->findOneBy([
				"token"     => $token,
				"userAgent" => UserUtil::getUserAgent(),
				"ipAddress" => UserUtil::getIpAddress()
			]);
		}
		if ($this->session === null) {
			//create new token
			do {
				$token = StringUtil::getRandomID();
			} while ($db->find(Session::class, $token) != null);

			$this->setCookie("session", $token);
			$this->data = [];
			$this->session = new Session();
			$this->session->setToken($token);
			$this->session->setRequestUri(CURRENT_URI);
			$this->session->setUserAgent(UserUtil::getUserAgent());
			$this->session->setIpAddress(new IP(UserUtil::getIpAddress()));
			$this->session->setData($this->data);
			$this->session->setLastAction(LOCAL_TIME);
			$db->persist($this->session);
			$db->flush();
		} else {
			$this->data = $this->session->getData();
			$this->user = $this->session->getUser();
		}
	}
}