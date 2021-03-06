<?php
declare(strict_types=1);

namespace RouteCMS\Controller;

use RouteCMS\Annotations\Controller\Form;
use RouteCMS\Annotations\Controller\FormParameter;
use RouteCMS\Controller\Parser\FormParser;
use RouteCMS\Controller\Parser\FormParserHandler;
use RouteCMS\Core\AnnotationHandler;
use RouteCMS\Exceptions\InputException;
use RouteCMS\Util\InputUtil;


/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
abstract class PostController extends BaseController
{

	/**
	 * @var FormParser[]
	 */
	protected $parser = [];

	/**
	 * @var InputException
	 */
	protected $error;

	/**
	 * @inheritdoc
	 */
	public function handle(...$args): void
	{
		$this->initAnnotations();
		if (mb_strtoupper(InputUtil::server("REQUEST_METHOD", "string", "GET")) == "POST") {
			$this->checkPermissions();
			if (!empty($args)) {
				$this->readParameters($args);
			}
			$this->readPostParameters();
			try {
				$this->validate();
				$this->submit();
			} catch (InputException $ex) {
				$this->error = $ex;
			}

			$this->show();
		} else {
			//handle default
			parent::handle();
		}
	}

	/**
	 * Load all annotations in this class
	 */
	protected function initAnnotations(): void
	{
		if (AnnotationHandler::instance()->hasAnnotation(get_called_class(), Form::class)) {
			$parser = $this->parser;
			AnnotationHandler::instance()->getPropertyAnnotation(get_called_class(), FormParameter::class, function ($name, $annotation) use (&$parser) {
				/** @var FormParameter $annotation */
				$parser[$name] = FormParserHandler::instance()->getParser($annotation->type, $annotation->default, $annotation->options);
			});
			$this->parser = $parser;
		}
		global $event;
		$event->call("initAnnotations", $this);
	}

	/**
	 * Read POST request parameters
	 */
	public function readPostParameters(): void
	{
		foreach ($this->parser as $name => $parser) {
			$parser->returnValue();
			$this->$name = $parser->getValue();
		}
	}

	/**
	 * Check input variable´s after POST
	 */
	public function validate(): void
	{
		//validate the default values
		foreach ($this->parser as $parser) {
			$parser->validateValue();
		}
	}

	/**
	 * Handle the POST request
	 */
	public function submit(): void
	{
		//do nothing by default
	}

	/**
	 * @return InputException
	 */
	public function getError(): InputException
	{
		return $this->error;
	}
}