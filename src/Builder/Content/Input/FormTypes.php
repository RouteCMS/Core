<?php
declare(strict_types=1);

namespace RouteCMS\Builder\Content\Input;

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 */
interface FormTypes
{
	const TEXT = "text";
	const PASSWORD = "password";
	const EMAIL = "email";
	const FILE = "file";
	const HIDDEN = "hidden";
	const URL = "url";
	const SEARCH = "search";
	const DATE = "date";
	const RADIO = "radio";
	const RANGE = "range";
	const NUMBER = "number";
	const TIME = "time";
	const COLOR = "color";
	const TELEPHONE = "tel";
}