<?php

namespace RouteCMS\Controller\Admin;

use RouteCMS\Annotations\Controller\Controller;
use RouteCMS\Annotations\Controller\ElementPrepend;
use RouteCMS\Annotations\Controller\Form;
use RouteCMS\Annotations\Controller\FormElement;
use RouteCMS\Annotations\Controller\FormParameter;
use RouteCMS\Controller\FormController;
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
class LoginController extends FormController
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
	 * @FormElement(placeholder="route-cms/global/username")
	 * @ElementPrepend(type="icon", content="user")
	 * @var string
	 */
	public $username = "";

	/**
	 * @FormParameter(name="password", default="")
	 * @FormElement(placeholder="route-cms/global/password")
	 * @ElementPrepend(type="icon", content="lock")
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