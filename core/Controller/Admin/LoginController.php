<?php

namespace RouteCMS\Controller\Admin;

use RouteCMS\Annotations\Controller\Controller;
use RouteCMS\Annotations\Controller\Form;
use RouteCMS\Annotations\Controller\FormParameter;
use RouteCMS\Controller\PostController;
use RouteCMS\Exceptions\InputException;
use RouteCMS\Model\User\User;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Controller(path="/login/", method={"GET", "POST"}, admin=true)
 * @Form
 */
class LoginController extends PostController
{

	/**
	 * @var string
	 */
	public $uniqueBodyId = "login";

	/**
	 * @var string
	 */
	public $title = "route-cms/core/login";

	/**
	 * @FormParameter(name="username", default="")
	 * @var string
	 */
	public $username = "";

	/**
	 * @FormParameter(name="password", default="")
	 * @var string
	 */
	public $password = "";

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @inheritDoc
	 */
	public function validate(): void
	{
		parent::validate();
		global $db;
		$this->user = $db->getRepository(User::class)->findOneBy([
			"username" => $this->username
		]);
		if ($this->user == null) {
			throw new InputException("username", txt("route-cms/global/form/invalid/username"));
		}
		if (!password_verify($this->password, $this->user->getPassword())) {
			throw new InputException("password", txt("route-cms/global/form/invalid/password"));
		}
		//TODO check user has admin permission
	}
}