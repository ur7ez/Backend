<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/6/17
 * Time: 20:10
 */

/** @var array $data from \App\Views\Base::render() */
$router = \App\Core\App::getRouter();

?>
<div class="col-lg-12">
    <h1><?= __('admin.pages_mgmt') ?></h1>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12 mb-15">
            <a class="btn btn-success"
               href="<?= $router->buildUri('edit') ?>"><?= __('admin.create_page') ?></a>
        </div>
    </div>
    <ul class="list-group">
        <li class="list-group-item active"><?= __('main.pages_list') ?></li>
        <? foreach ($data as $page): ?>
            <li class="list-group-item">
                <a class="btn btn-success btn-sm"
                   href="<?= $router->buildUri('edit', [$page['id']]) ?>">Edit</a>
                <a class="btn btn-sm btn-warning" onclick="return confirmDelete();"
                   href="<?= $router->buildUri('delete', [$page['id']]) ?>">Delete</a>
                <?= $page['title'] ?>
            </li>
        <? endforeach; ?>
    </ul>
</div>
