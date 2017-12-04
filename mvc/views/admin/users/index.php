<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.11.2017
 * Time: 18:01
 */
/** @var array $data from \App\Views\Base::render() */
$router = \App\Core\App::getRouter();
$session = \App\Core\App::getSession();
?>
<div class="col-lg-12">
    <h1><?= __('admin.users_list') ?></h1>
</div>
<div class="row">
    <table class="table table-bordered table-hover">
        <caption align="right"><i><?= __('admin.users') ?></i></caption>
        <thead class="thead-light">
        <tr align="center">
            <th scope="col"><?= __('users.todo') ?></th>
            <th scope="col"><?= __('users.login') ?></th>
            <th scope="col"><?= __('users.email') ?></th>
            <th scope="col"><?= __('users.role') ?></th>
            <th scope="col"><?= __('users.active') ?></th>
        </tr>
        </thead>
        <? foreach ($data as $users): ?>
            <tr <?= ($users['login'] === $session->get('login')) ? 'class="table-danger"' : '' ?>>
                <td>
                    <a class="btn btn-success btn-sm"
                       href="<?= $router->buildUri('edit', [$users['id']]) ?>">Edit</a>
                    <a class="btn btn-sm btn-warning" onclick="return confirmDelete();"
                       href="<?= $router->buildUri('delete', [$users['id']]) ?>">Delete</a>
                </td>
                <td><?= $users['login'] ?></td>
                <td><?= $users['email'] ?></td>
                <td><?= $users['role'] ?></td>
                <td style="text-align: center"><input type="checkbox" <?= ($users['active'])? 'checked':'' ?> disabled></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>