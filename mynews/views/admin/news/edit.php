<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 20.11.2017
 * Time: 19:56
 */

/**
 * @var array $data from \App\Views\Base::render()
 * @var \App\Core\Router $router from \App\Core\App::getRouter()
 */
$isNew = empty($data) || isset($data['new']);
?>
<div class="col-lg-12">
    <h1><?= ($isNew ? __('admin.create_page') : __('admin.edit_page')) ?></h1>
</div>

<div class="col-lg-12">
    <form action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="title" title="page title"
                   value="<?= (isset($data['title']) ? $data['title'] : '') ?>"
                   placeholder="page title">
        </div>
        <div class="form-group">
            <textarea rows="15" class="form-control" name="content" title="page content" placeholder="page content"><?= (isset($data['content']) ? $data['content'] : '') ?></textarea>
        </div>
        <div class="form-group">
            <label for="active">Publish page</label>
            <input type="checkbox" value="1" id="active"
                   name="active" <?= ($isNew || $data['active'] ? 'checked' : '') ?>>
        </div>
        <button type="submit" class="btn btn-success"><?= __('form.save') ?></button>
        <button type="reset" class="btn btn-secondary"><?= __('form.reset') ?></button>
    </form>
</div>