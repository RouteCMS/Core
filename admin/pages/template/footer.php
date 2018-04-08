<?php
declare(strict_types=1);

/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @var \RouteCMS\Controller\BaseController $this
 */
?>
<script type="application/javascript" src="<?php js(DEV_MODE ? "require.js" : "require.min.js", true) ?>"></script>
<?php if (!DEV_MODE) { ?>
    <script type="application/javascript" src="<?php js("combined.min.js", true) ?>"></script>
<?php } ?>
<script type="text/javascript">
    requirejs.config({
        baseUrl: "<?php js("require/", true) ?>"
    });

    require(["jquery", "popper"], function ($, p) {
        console.log($, p);
        require(["bootstrap"], function (b) {
        });
    });
</script>
</body>
</html>