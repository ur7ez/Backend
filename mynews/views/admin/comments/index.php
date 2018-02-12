<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.11.2017
 * Time: 14:43
 */

/**
 * @var array $data from \App\Views\Base::render()
 * @var \App\Core\Router $router from \App\Core\App::getRouter()
 */

?>
<div class="col-lg-12">
    <h3><?= __('admin.contacts_view') ?>:</h3>
</div>

<div class="row">
    <table class="table table-bordered table-hover table-sm">
        <caption align="right"><i><?= __('admin.contacts_list') ?></i></caption>
        <thead class="thead-light">
        <tr align="center">
            <th scope="col">Действия</th>
            <th scope="col">Name</th>
            <th scope="col">E-mail</th>
            <th scope="col">Message</th>
        </tr>
        </thead>
        <? foreach ($data as $contact): ?>
            <tr>
                <td>
                    <a class="btn btn-success btn-sm"
                       href="<?= $router->buildUri('edit', [$contact['id']]) ?>">Edit</a>
                    <a class="btn btn-sm btn-warning" onclick="return confirmDelete();"
                       href="<?= $router->buildUri('delete', [$contact['id']]) ?>">Delete</a>
                </td>
                <td><?= $contact['name'] ?></td>
                <td><?= $contact['email'] ?></td>
                <td><?= $contact['messages'] ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>