<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 19.11.2017
 * Time: 14:12
 */
$router = \App\Core\App::getRouter();
?>
<div class="col-lg-12">
    <h3><?= __('header.login') ?></h3>
</div>

<form action="" method="post">
    <label for="login" class="form-control-label">Login: </label>
    <input type="text" id="login" name="login" class="form-control" placeholder="your login" autofocus required>
    <label for="password" class="form-control-label">Password: </label>
    <input type="password" id="password" name="password" class="form-control" placeholder="your password"
           required>
    <br>
    <input type="submit" class="btn btn-success" value="<?= __('form.send') ?>">
    <a class="btn btn-success" href="<?= $router->buildUri('users.register') ?>"><?= __('header.register') ?></a>
</form>
