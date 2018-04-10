<?php
declare(strict_types=1);

namespace Simple\CRM\Model\Log;

use Doctrine\ORM\Mapping as ORM;
use RouteCMS\Doctrine\LogSeverity;
use RouteCMS\Model\Interfaces\IDInterface;
use RouteCMS\Model\Interfaces\TimeInterface;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="logType", type="string")
 */
abstract class LogEntry
{

	use TimeInterface;
	use IDInterface;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 *
	 * @var string
	 */
	protected $error = null;

	/**
	 * @var string
	 * @ORM\Column(name="severity",type="logSeverity", nullable=false)
	 */
	protected $severity = LogSeverity::NONE;

	/**
	 * @return string
	 */
	public function getError(): string
	{
		return $this->error;
	}

	/**
	 * @param string $error
	 */
	public function setError(string $error): void
	{
		$this->error = $error;
	}

	/**
	 * @return string
	 */
	public function getSeverity(): string
	{
		return $this->severity;
	}

	/**
	 * @param string $severity
	 */
	public function setSeverity(string $severity): void
	{
		$this->severity = $severity;
	}
}