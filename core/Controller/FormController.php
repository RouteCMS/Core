<?php
declare(strict_types=1);

namespace RouteCMS\Controller;

use RouteCMS\Annotations\Controller\ElementPrepend;
use RouteCMS\Annotations\Controller\FormElement;
use RouteCMS\Builder\Bootstrap\Content\InputGroup;
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

		AnnotationHandler::instance()->getPropertyAnnotationWithOther(get_called_class(), FormElement::class, function ($name, $annotation, $annotations) {
			/** @var FormElement $annotation */
			/** @var array $annotations */
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
				}
			}
			if (!isset($this->parser[$name])) return;
			$formParameter = $this->parser[$name];

			$container->addInput($formParameter->getValueOut(), $annotation->type, $name, $annotation->placeholder, $annotation->properties, $annotation->classList);
			foreach ($afterPrepend as $item) {
				$container->addPrependContent([
					$item->type => $item->content
				]);
			}
			$this->contentBuilder->addContent($container);
		});
		
		global $event;
		$event->call("afterBuildContent", $this);
		parent::show();
	}
}