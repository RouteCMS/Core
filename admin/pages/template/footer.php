<?php
declare(strict_types=1);
/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @var \RouteCMS\Controller\BaseController $this
 */

use RouteCMS\Compiler\AdminStyleHandler;

foreach (AdminStyleHandler::instance()->getScript() as $file) { ?>
    <script type="application/javascript" src="<?php js(str_replace(".js", ".min.js", $file), true) ?>"></script>
<?php } ?>
</body>
</html>