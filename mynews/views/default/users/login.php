<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 19.11.2017
 * Time: 14:12
 */

/**
 * @var \App\Core\Router $router from \App\Core\App::getRouter()
 */

?>
<div class="col-lg-12">
    <h3><?= __('header.login') ?></h3>
    <form action="" method="post">
        <fieldset>
            <label for="login" class="form-control-label"><?= __('form.login') ?>: </label>
            <input type="text" id="login" name="login" class="form-control"
                   placeholder="<?= __('general.your') . " " . __('form.login') ?>"
                   autofocus required>
            <label for="password" class="form-control-label"><?= __('form.password') ?>: </label>
            <input type="password" id="password" name="password" class="form-control"
                   placeholder="<?= __('general.your') . " " . __('form.password') ?>"
                   required>
            <br>
            <input type="submit" class="btn btn-success" value="<?= __('form.sign-in') ?>">
            <a class="btn btn-outline-info"
               href="<?= $router->buildUri('users.register') ?>"><?= __('header.register') ?></a>
        </fieldset>
    </form>
</div>