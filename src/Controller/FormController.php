<?php
declare(strict_types=1);

namespace RouteCMS\Controller;

use RouteCMS\Annotations\Controller\ElementPrepend;
use RouteCMS\Annotations\Controller\FormElement;
use RouteCMS\Builder\Bootstrap\Content\InputGroup;
use RouteCMS\Builder\Content\DefaultContent;
use RouteCMS\Builder\DefaultContentBuilder;
use RouteCMS\Builder\FormBuilder;
use RouteCMS\Core\AnnotationHandler;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
abstract class FormController extends PostController
{

	use FormBuilder;

	/**
	 * @inheritdoc
	 */
	public function show(): void
	{
		$this->contentBuilder = new DefaultContentBuilder(get_called_class());
		global $event;
		$event->call("beforeBuildContent", $this);

		AnnotationHandler::instance()->getPropertyAnnotationWithOther(get_called_class(), FormElement::class, [$this, 'eventContentBuilder']);
		$event->call("afterBuildContent", $this);
		parent::show();
	}

	/**
	 * @param string      $name
	 * @param FormElement $annotation
	 * @param array       $annotations
	 */
	public function eventContentBuilder($name, $annotation, $annotations)
	{
		global $event;
		$afterPrepend = [];
		$container = new InputGroup();
		foreach ($annotations as $item) {
			switch (get_class($item)) {
				case ElementPrepend::class:
					if (!$item->before) {
						$afterPrepend[] = $item;
						continue;
					}
					$container->addPrependContent([
						$item->type => $item->content
					]);
					break;
				default:
			}
		}
		if (!isset($this->parser[$name])) return;
		
		$formParameter = $this->parser[$name];
		$params = [
			"parser"      => &$formParameter,
			"annotation"  => $annotation,
			"name"        => $name,
			"annotations" => $annotations
		];
		$error = $this->error !== null && $this->error->getField() == $name;
		$event->call("contentBuilder", $this, $params);
		$container->addInput($formParameter->getValueOut(), $annotation->type, $name, $annotation->placeholder, $annotation->properties, $error ? array_merge(['is-invalid'], $annotation->classList) : $annotation->classList);
		if($error){
			$container->addContent((new DefaultContent("div", $this->error->getMessage()))->addClass('invalid-feedback'));
		}
		foreach ($afterPrepend as $item) {
			$container->addPrependContent([
				$item->type => $item->content
			]);
		}
		$this->contentBuilder->addContent($container);
	}
}