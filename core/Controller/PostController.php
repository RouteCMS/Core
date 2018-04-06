<?php

namespace RouteCMS\Controller;

use RouteCMS\Annotations\AnnotationHandler;
use RouteCMS\Annotations\Controller\Form;
use RouteCMS\Annotations\Controller\FormParameter;
use RouteCMS\Controller\Parser\FormParser;
use RouteCMS\Exceptions\InputException;
use RouteCMS\Exceptions\SystemException;
use RouteCMS\Util\InputUtil;


/**
 * @author        Olaf Braun
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
	 * @inheritdoc
	 */
	public function handle(...$args): void
	{
		if (AnnotationHandler::instance()->hasAnnotation(get_called_class(), Form::class)) {
			$parser = $this->parser;
			AnnotationHandler::instance()->getPropertyAnnotation(get_called_class(), FormParameter::class, function ($name, $annotation) use (&$parser) {
				/** @var FormParameter $annotation */
				$parserClass = 'RouteCMS\\Controller\\Parser\\' . ucfirst($annotation->type) . "FormParser";
				if (!class_exists($parserClass) && is_subclass_of($parserClass, FormParser::class)) {
					throw new SystemException("Form parser of type '$annotation->type' couldn't found!");
				}
				$parser[$name] = new $parserClass($name, $annotation->default, $annotation->options);
			});
			$this->parser = $parser;
		}
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
				$ex->show();
			}

			$this->show();
		} else {
			//handle default
			parent::handle();
		}
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
}