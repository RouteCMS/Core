<?php
declare(strict_types=1);

namespace RouteCMS\Exceptions;

/**
 * @author        Olaf Braun
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
class SystemException extends \Exception
{

	/**
	 * The error severity
	 *
	 * @var string
	 */
	protected $severity;

	/**
	 * @inheritDoc
	 */
	public function __construct(string $message = "", int $code = 0, int $severity = 1, string $filename = __FILE__, int $lineNo = __LINE__, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->severity = $severity;
		$this->file = $filename;
		$this->line = $lineNo;
	}

	/**
	 * @inheritDoc
	 */
	public function getSeverity(): string
	{
		return $this->severity;
	}
}