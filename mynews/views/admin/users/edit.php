<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.11.2017
 * Time: 15:25
 */
/** @var array $data from \App\Views\Base::render() */
?>
<div class="col-lg-12">
    <h1><?= __('admin.edit_user') ?></h1>
</div>

<div class="col-lg-12">
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="userLogin">User name</label>
                <input type="text" class="form-control" name="name" title="user name"
                       value="<?= (isset($data['name']) ? $data['name'] : '') ?>"
                       placeholder="user name" id="userName">
            </div>
            <div class="form-group col-md-3">
                <label for="userLogin">User login</label>
                <input type="text" class="form-control" name="login" title="user login"
                       value="<?= (isset($data['login']) ? $data['login'] : '') ?>"
                       placeholder="user login" id="userLogin">
            </div>
            <div class="form-group col-md-3">
                <label for="userEmail">User email</label>
                <input type="email" class="form-control" name="email" title="user e-mail"
                       value="<?= (isset($data['email']) ? $data['email'] : '') ?>"
                       placeholder="user e-mail" id="userEmail">
            </div>
            <div class="form-group col-md-3">
                <label for="userRole">User role</label>
                <input type="text" class="form-control" name="role" title="user role"
                       value="<?= (isset($data['role']) ? $data['role'] : '') ?>"
                       placeholder="user role" id="userRole">
                <input type="hidden" class="form-control" name="password"
                       value="<?= (isset($data['password']) ? $data['password'] : '') ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="active"><?= __('admin.users_edit_active') ?></label>
            <input type="checkbox" value="1" id="active"
                   name="active" <?= ($data['active'] ? '' : 'checked') ?>>
        </div>
        <button type="submit" class="btn btn-primary"><?= __('form.save') ?></button>
        <button type="reset" class="btn btn-secondary"><?= __('form.reset') ?></button>
    </form>
</div>