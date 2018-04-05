<?php

namespace RouteCMS\Exceptions;

use RouteCMS\Util\InputUtil;
use RouteCMS\Util\SystemUtil;
use Whoops\Handler\Handler;
use Whoops\Handler\PlainTextHandler;
use Zend\Text\Table\Column;
use Zend\Text\Table\Decorator\Blank;
use Zend\Text\Table\Table;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class FileExceptionHandler extends PlainTextHandler
{

	const MAX_COLUMN_LENGTH = 500;

	/**
	 * @inheritdoc
	 */
	public function handle()
	{
		$ex = $this->getException();
		if ($ex instanceof IPrintableException) {
			return Handler::DONE;
		}
		$logFile = GLOBAL_DIR . 'log/' . gmdate('Y-m-d', LOCAL_TIME) . '.txt';
		touch($logFile);

		file_put_contents($logFile, $this->formatException(), FILE_APPEND);

		return Handler::DONE;
	}

	/**
	 * @return string
	 */
	private function formatException()
	{
		$table = new Table(['columnWidths' => [20, self::MAX_COLUMN_LENGTH]]);
		$table->setDecorator(new Blank());
		$table->appendRow(["Message", $this->getException()->getMessage()]);
		$table->appendRow(["PHP version", phpversion()]);
		$table->appendRow(["Request URI", InputUtil::server("REQUEST_URI", "string", "")]);
		$table->appendRow(["User Agent", str_replace("\n", ' ', InputUtil::server("HTTP_USER_AGENT", "string", ""))]);
		$table->appendRow(["Peak Memory Usage", memory_get_peak_usage() . '/' . SystemUtil::getMemoryLimit()]);
		$table->appendRow(["Stacktrace"]);
		$plain = $table->render();

		$frames = $this->getInspector()->getFrames();
		$table = new Table(['columnWidths' => [5, self::MAX_COLUMN_LENGTH]]);
		$table->setPadding(1);
		$table->setDefaultColumnAlign(0, Column::ALIGN_RIGHT);
		$table->setDefaultColumnAlign(1, Column::ALIGN_LEFT);
		$table->setDecorator(new Blank());
		foreach ($frames as $i => $frame) {
			$index = (string)(count($frames) - $i - 1);
			$message = $frame->getClass() . ($frame->getClass() && $frame->getFunction() ? ":" : "") . ($frame->getFunction() ?: '') . ' in ' . ($frame->getFile() ?: '<#unknown>') . ':' . (int)$frame->getLine();

			$table->appendRow([
				$index, $message
			]);
		}
		$plain .= $table->render();

		return "-----------" . sha1($plain) . "-------\n" . $plain . "-------\n\n\n\n";
	}
}