<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/6/17
 * Time: 20:25
 */

/** @var array $data from \App\Views\Base::render() */

$router = \App\Core\App::getRouter();
$session = \App\Core\App::getSession();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin | <?= \App\Core\Config::get('siteName') ?></title>
    <link rel="icon" href="/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/admin.css">
    <script type="application/javascript" src="/js/admin.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/"><?= __('header.homepage') ?> (Admin)</a>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= $router->buildUri('pages.index') ?>"><?= __('header.pages') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->buildUri('contacts.index') ?>"><?= __('admin.header_contacts') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->buildUri('users.index') ?>"><?= __('admin.header_users') ?></a>
            </li>
            <?php if (\App\Core\Session::get('login')) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->buildUri('default.users.logout') ?>"><?= __('header.logout') ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>

<main class="container main">
    <div class="row">
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
</body>
</html>
