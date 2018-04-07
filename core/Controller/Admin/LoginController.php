<?php

namespace RouteCMS\Controller\Admin;

use RouteCMS\Annotations\Controller\Controller;
use RouteCMS\Annotations\Controller\Form;
use RouteCMS\Annotations\Controller\FormParameter;
use RouteCMS\Controller\PostController;
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
	 * @FormParameter(name="username", default="")
	 * @var string
	 */
	protected $username = "";

	/**
	 * @FormParameter(name="password", default="")
	 * @var string
	 */
	protected $password = "";

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
		//TODO validate login data from user
	}
}