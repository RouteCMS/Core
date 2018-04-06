<?php
declare(strict_types=1);

namespace RouteCMS\Controller;

use RouteCMS\Annotations\AnnotationHandler;
use RouteCMS\Annotations\Controller\Controller;
use RouteCMS\Annotations\controller\RequestParameter;
use RouteCMS\Util\Formatter;
use voku\helper\HtmlMin;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
abstract class BaseController
{

	/**
	 * @var string
	 */
	public $title = "";

	/**
	 * @var bool
	 */
	public $loginRequired = false;

	/**
	 * @var bool
	 */
	public $redirect = false;

	/**
	 * @var string
	 */
	protected $content = "";

	/**
	 * @var string
	 */
	protected $contentType = ContentType::HTML;

	/**
	 * @var bool
	 */
	private $isAdmin = false;

	/**
	 * BaseController constructor.
	 */
	public final function __construct()
	{
		$isAdmin = false;
		AnnotationHandler::instance()->getAnnotation(get_called_class(), Controller::class, function ($annotation) use (&$isAdmin) {
			/** @var Controller $annotation */
			$isAdmin = $annotation->admin;
		});
		$this->isAdmin = $isAdmin;
	}

	/**
	 * Show the local page
	 *
	 * @param array $args
	 */
	public function handle(...$args): void
	{
		$this->readParameters($args);
		$this->checkPermissions();

		$this->show();
	}

	/**
	 * Read request parameters
	 *
	 * @param array $values
	 */
	public function readParameters($values): void
	{
		AnnotationHandler::instance()->getPropertyAnnotation(get_called_class(), RequestParameter::class, function ($name, $annotation) use ($values) {
			/** @var RequestParameter $annotation */
			if (isset($values[$annotation->position])) $this->$name = $values[$annotation->position];
		});
	}

	/**
	 * Check if the local user can enter this page
	 */
	public function checkPermissions(): void
	{
		//TODO check permission
	}

	/**
	 * Show this controller content
	 */
	protected function show(): void
	{
		//TODO show this page
	}

	/**
	 * Send content to client
	 */
	public function sendContent(): void
	{
		//clean content before
		ob_clean();
		if ($this->contentType == ContentType::HTML) {
			if (HTML_FORMATTER) {
				$format = new Formatter();
				$this->content = $format->HTML($this->content);
			}
			if (HTML_MINIFY) {
				$htmlMin = new HtmlMin();
				$htmlMin->doRemoveDefaultAttributes();
				$this->content = $htmlMin->minify($this->content);
			}
		}
		echo $this->content;
	}

	/**
	 * @return bool
	 */
	public function isAdmin(): bool
	{
		return $this->isAdmin;
	}
}