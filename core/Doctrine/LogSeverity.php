<?php
declare(strict_types=1);

namespace RouteCMS\Doctrine;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;
use RouteCMS\Annotations\Database\EnumColumn;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @EnumColumn(name="logSeverity")
 */
class LogSeverity extends AbstractEnumType
{

	const INFO = 'INFO';

	const WARNING = 'WARNING';

	const FATAL = 'FATAL';

	const NONE = 'NONE';

	protected static $choices = [
		self::INFO    => 'Info',
		self::WARNING => 'Warning',
		self::FATAL   => 'Fatal',
		self::NONE    => 'None'
	];
}