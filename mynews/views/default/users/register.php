<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 19.11.2017
 * Time: 1:36
 */
?>
<div class="col-lg-12">
    <h3><?= __('main.register') ?></h3>
</div>

<form action="" method="post">
    <fieldset>
        <label for="name"><?= __('form.name') ?>:
            <input type="text" id="name" name="name" class="form-control"
                   placeholder="имя пользователя" autofocus>
        </label>
        <label for="login"><?= __('form.login') ?>:
            <input type="text" id="login" name="login" class="form-control"
                   placeholder="<?= __('form.choose_your_login') ?>" required>
        </label>
        <label for="email"><?= __('form.email') ?>:
            <input type="email" id="email" name="email" class="form-control"
                   placeholder="<?= __('form.your_e-mail_here') ?>" required>
        </label><br>
        <label for="password"><?= __('form.password') ?>:
            <input type="password" id="password" name="password" class="form-control"
                   placeholder="<?= __('form.enter_password') ?>" required>
        </label>
        <label for="password_cfm"><?= __('form.confirm') . " " . __('form.password') ?>:
            <input type="password" id="password_cfm" name="password_cfm" class="form-control"
                   placeholder="<?= __('form.confirm_password') ?>" required>
        </label><br>
        <input type="submit" class="btn btn-success" value="<?= __('form.register') ?>">
    </fieldset>
</form>