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
    <label for="login">Login:
    <input type="text" id="login" name="login" class="form-control" placeholder="choose your login" autofocus
           required>
    </label>
    <label for="email">E-mail:
    <input type="email" id="email" name="email" class="form-control" placeholder="your e-mail here" required>
    </label>
    <label for="password">Password:
    <input type="password" id="password" name="password" class="form-control" placeholder="enter password" required>
    </label>
    <label for="password_cfm">Confirm password:
    <input type="password" id="password_cfm" name="password_cfm" class="form-control" placeholder="confirm password"
           required>
    </label><br>
    <input type="submit" class="btn btn-success" value="<?= __('form.send') ?>">
</form>