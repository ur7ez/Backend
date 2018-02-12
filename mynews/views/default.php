<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 11/6/17
 * Time: 20:25
 */

/**
 * @var array $data from \App\Views\Base::render()
 * @var \App\Core\Router $router from \App\Core\App::getRouter()
 */
$session = \App\Core\App::getSession();
$ctrlr = strtolower($router->getController(true));
?>
<!DOCTYPE html>
<html lang="<?= $router->getLang() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= \App\Core\Config::get('siteName') ?></title>
    <link rel="icon" href="/favicon.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="<?= (App\Core\Config::get('debug')) ? '/css/bootstrap.min.css' : 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' ?>">
    <!-- шрифты Font-Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!--    <link rel="stylesheet" href="/css/fontawesome-all.min.css">-->
    <link rel="stylesheet" href="/css/default.css">
    <link rel="stylesheet" href="/css/carousel.css">
</head>
<body class="bg-light" data-ng-app="myNews">
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top pt-1 pb-1">
    <a class="navbar-brand" href="/">
        <img class="mr-3" src="/img/logo.svg" alt="" width="43" height="43"><?= __('header.homepage') ?>
    </a>
    <button class="navbar-toggler p-0 border-0 collapsed" type="button" data-toggle="collapse"
            data-target="#offcanvas" aria-expanded="true" aria-controls="offcanvas">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="offcanvas" data-ng-controller="menuController as menu">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link<?= ($ctrlr === 'categories') ? ' active' : '' ?>"
                   href="<?= $router->buildUri('categories.index') ?>"><?= __('header.all') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= ($ctrlr === 'news') ? ' active' : '' ?>"
                   href="<?= $router->buildUri('news.index') ?>"><?= __('header.by_categories') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= ($ctrlr === 'tags') ? ' active' : '' ?>"
                   href="<?= $router->buildUri('tags.index') ?>"><?= __('header.by_tags') ?></a>
            </li>

            <li class="nav-item dropdown" data-ng-repeat="main in menu.menuItems">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{main.menu}}
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#" data-ng-repeat="sub in main.submenu">
                        <i data-ng-if="sub.imgClass !== '' && sub.imgClass !== undefined" class="fa {{sub.imgClass}}"
                           aria-hidden="true"></i>{{sub.name}}
                    </a>
                    <div class="dropdown-menu" data-ng-repeat="subsub in sub.submenu"
                         aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">
                            <i data-ng-if="sub.imgClass !== '' && sub.imgClass !== undefined"
                               class="fa {{sub.imgClass}}" aria-hidden="true"></i>{{subsub.name}}
                        </a>
                    </div>
                </div>
            </li>

        </ul>

        <form class="form-inline my-2 my-lg-0">
            <label class="sr-only" for="searchGlobal">Search globally</label>
            <input class="form-control mr-sm-2" id="searchGlobal" type="search" placeholder="<?= __('form.search') ?>"
                   aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?= __('form.search') ?></button>
        </form>

        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <?php if ($session->get('login')) { ?>
                    <a class="nav-link" href="<?= $router->buildUri('users.logout') ?>"><?= __('header.logout') ?></a>
                <?php } else { ?>
                    <a class="nav-link" href="<?= $router->buildUri('users.login') ?>"><?= __('nav-items.login') ?></a>
                <? } ?>
            </li>
        </ul>
    </div>
</nav>

<main class="container-flex pt-3 px-3 pb-1" role="main">
    <div class="row flex-xl-wrap">
        <? if ($session->hasFlash()):
            foreach ($session->flash() as $msg): ?>
                <div class="alert alert-info" role="alert">
                    <?= $msg ?>
                </div>
            <? endforeach;
        endif; ?>
        <?= $data['content'] ?>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <span class="text-muted">(c) Mike Nykytenko. Feb. 2018</span>
    </div>
</footer>

<? if (App\Core\Config::get('debug')): ?>
    <script src="/js/jquery-3.2.1.slim.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <!-- AngularJS 1.6.7 -->
    <script src="/js/angular.min.js"></script>
    <!--<script src="/js/angular-route.min.js"></script>
    <script src="/js/angular-sanitize.js"></script>
    -->
<? else: ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- AngularJS 1.6.7 -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular.min.js"></script>
    <!--<script src="https://code.angularjs.org/1.6.7/angular-route.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular-sanitize.js"></script>
    -->
<? endif; ?>
<!-- AngularJS custom controller -->
<script src="/js/app.js"></script>
<!--<script src="/js/services/services.js"></script>-->
</body>
</html>