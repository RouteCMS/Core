<?php
declare(strict_types=1);

namespace RouteCMS\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;
use RouteCMS\Util\StringUtil;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @Annotation
 * @Target({"CLASS"})
 */
class Cronjob
{

	/**
	 * @var string
	 */
	public $minute = "*";

	/**
	 * @var string
	 */
	public $hour = "*";

	/**
	 * @var string
	 */
	public $day = "*";

	/**
	 * @var string
	 */
	public $month = "*";

	/**
	 * @var string
	 */
	public $weekDay = "*";

	/**
	 * @return string
	 */
	public function getExpression(): string
	{
		return $this->convertStringToExpression($this->minute) . " " . $this->convertStringToExpression($this->hour) . " " . $this->convertStringToExpression($this->day) . " " . $this->convertStringToExpression($this->month) . " " . $this->convertStringToExpression($this->weekDay);
	}

	/**
	 * @param string $string
	 *
	 * @return string
	 */
	private function convertStringToExpression($string): string
	{
		if (StringUtil::startsWith("Each", $string)) {
			return str_replace("Each ", "*/", $string);
		}

		return $string;
	}
}