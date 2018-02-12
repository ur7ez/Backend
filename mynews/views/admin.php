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
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | <?= \App\Core\Config::get('siteName') ?></title>
    <link rel="icon" href="/favicon.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="<?= (App\Core\Config::get('debug')) ? '/css/bootstrap.min.css' : 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' ?>">
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-md navbar-light fixed-top pt-1 pb-1" style="background-color: #e3f2fd;">
    <a class="navbar-brand" href="/">
        <img class="mr-3" src="/img/logo.svg" alt="" width="43" height="43"><?= __('header.homepage') ?> (admin)
    </a>
    <button class="navbar-toggler p-0 border-0 collapsed" type="button" data-toggle="collapse"
            data-target="#offcanvas" aria-expanded="true" aria-controls="offcanvas">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="offcanvas">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link<?= ($ctrlr === 'categories') ? ' active' : '' ?>"
                   href="<?= $router->buildUri('categories.index') ?>"
                   title="редактирование категорий"><?= __('admin.categories') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= ($ctrlr === 'news') ? ' active' : '' ?>"
                   href="<?= $router->buildUri('news.index') ?>"
                   title="редактирование новостей"><?= __('admin.news') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled<?= ($ctrlr === 'comments') ? ' active' : '' ?>"
                   href="<?= $router->buildUri('comments.index') ?>"
                   title="редактирование комментариев пользователей"><?= __('admin.header_comments') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= ($ctrlr === 'users') ? ' active' : '' ?>"
                   href="<?= $router->buildUri('users.index') ?>"
                   title="редактирование пользователей"><?= __('admin.header_users') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled<?= ($ctrlr === 'ads') ? ' active' : '' ?>"
                   href="<?= $router->buildUri('ads.index') ?>"
                   title="редактирование рекламных блоков"><?= __('admin.ads') ?></a>
            </li>
        </ul>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <?php if (\App\Core\Session::get('login')) { ?>
                    <a class="nav-link"
                       href="<?= $router->buildUri('default.users.logout') ?>"><?= __('header.logout') ?></a>
                <?php } ?>
            </li>
        </ul>
    </div>
</nav>

<main class="container container-fluid main my-5 px-0">
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
<script src="/js/admin.js"></script>
</body>
</html>
