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
    <h1><?= __('admin.edit_contact') ?></h1>
</div>

<div class="col-lg-12">
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="userName">User name</label>
                <input type="text" class="form-control" name="name" title="user name"
                       value="<?= (isset($data['name']) ? $data['name'] : '') ?>"
                       placeholder="user name" id="userName">
            </div>
            <div class="form-group col-md-4">
                <label for="userEmail">User email</label>
                <input type="email" class="form-control" name="email" title="user e-mail"
                       value="<?= (isset($data['email']) ? $data['email'] : '') ?>"
                       placeholder="user e-mail" id="userEmail">
            </div>
        </div>
        <div class="form-group col-md-8">
            <textarea rows="7" class="form-control" autofocus
                      name="messages" title="user message"
                      placeholder="user message"><?= (isset($data['messages']) ? $data['messages'] : '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?= __('form.save') ?></button>
        <button type="reset" class="btn btn-secondary"><?= __('form.reset') ?></button>
    </form>
</div>