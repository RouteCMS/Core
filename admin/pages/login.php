<?php
declare(strict_types=1);
/**
 * @author        Olaf Braun <info@braun-development.de>
 * @copyright     2013-2018 Olaf Braun - Software Development
 * @license       GNU Lesser General Public License <https://opensource.org/licenses/LGPL-3.0>
 *
 * @var \RouteCMS\Controller\Admin\LoginController $this
 */

use RouteCMS\Bootstrap\BootstrapContentBuilder;
use RouteCMS\Builder\Bootstrap\Content\InputGroup;
use RouteCMS\Builder\Content\Input\FormTypes;

include "template/header.php";
global $link;
?>
    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column text-center">
        <header class="mb-auto"></header>
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
                <form method="post" action="<?php echo $link->buildLink([
					"admin" => true,
					"path"  => "login"
				]); ?>">
                    <div class="card-body rounded-0 border-0">
						<?php
						$contentBuilder = new BootstrapContentBuilder("form");
						$contentBuilder->addContent((new InputGroup())
							->addPrependIcon("user")
							->addInput($this->username, FormTypes::TEXT, "username", txt("route-cms/global/username"), [], [
								"aria-label" => txt("route-cms/global/username")
							])
						);
						echo $contentBuilder->getHtml();
						?>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fa fa-lock" aria-hidden="true"></span>
                                </span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="<?php pr("route-cms/global/password") ?>" aria-label="<?php pr("route-cms/global/password") ?>">
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
        <footer class="mt-auto"></footer>
    </div>
<?php
include "template/footer.php";
