<?php
declare(strict_types=1);
/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @var \RouteCMS\Controller\Admin\LoginController $this
 */
include "template/header.php";
global $link;
?>
    <div class="login-panel text-center">
        <main role="main" class="inner cover">
            <h1 class="cover-heading">
                <a href="<?php echo $link->buildLink([
					"admin" => true
				]); ?>">
                    <img src="<?php img("logo.png", true) ?>" alt="logo"/>
                </a>
            </h1>
            <div class="card rounded-0 border-0 bg-transparent">
                <div class="card-header rounded-0 border-0">
					<?php pr("route-cms/core/login/area") ?>
                </div>
                <form method="post">
                    <div class="card-body rounded-0 border-0">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fa fa-user" aria-hidden="true"></span>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="<?php pr("route-cms/global/username") ?>" aria-label="<?php pr("route-cms/global/username") ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fa fa-lock" aria-hidden="true"></span>
                                </span>
                            </div>
                            <input type="password" class="form-control" placeholder="<?php pr("route-cms/global/password") ?>" aria-label="<?php pr("route-cms/global/password") ?>">
                        </div>
                    </div>
                    <div class="card-footer rounded-0 border-0">
                        <button type="submit" class="btn btn-link">
                            <span class="fa fa-sign-in"></span> <?php pr("route-cms/core/login/in") ?>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
<?php
include "template/footer.php";
