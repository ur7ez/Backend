<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/6/17
 * Time: 20:10
 */

/**
 * @var array $data from \App\Views\Base::render()
 * @var \App\Core\Router $router from \App\Core\App::getRouter()
 */

?>
<h1 class="text-info mx-auto"><?= __('admin.categories_mgmt') ?></h1>

<div class="col-lg-12">
    <div>
        <a class="btn btn-success"
           href="<?= $router->buildUri('edit') ?>"><?= __('admin.create_category') ?></a>
    </div>

    <div class="row table-sm">
        <table class="table table-bordered table-hover">
            <caption align="right"><i><?= __('main.categories_list') ?></i></caption>
            <thead class="thead-light">
            <tr align="center">
                <th scope="col">Действия</th>
                <th scope="col">Наименование</th>
                <th scope="col">Описание</th>
                <th scope="col">Заголовок</th>
                <th scope="col">Ограничен доступ?</th>
                <th scope="col">Комментарии модерируются?</th>
                <th scope="col">Активна?</th>
            </tr>
            </thead>
            <? foreach ($data as $category): ?>
                <tr>
                    <td>
                        <a class="btn btn-success btn-sm"
                           href="<?= $router->buildUri('edit', [$category['id']]) ?>"><?= __('general.edit') ?></a>
                        <a class="btn btn-sm btn-warning" onclick="return confirmDelete();"
                           href="<?= $router->buildUri('delete', [$category['id']]) ?>"><?= __('general.delete') ?></a>
                    </td>
                    <td><?= $category['title'] ?></td>
                    <td><?= $category['description'] ?></td>
                    <td><?= $category['header'] ?></td>
                    <td class="text-center"><?= $category['restricted'] ?></td>
                    <td class="text-center"><?= $category['comments_moderated'] ?></td>
                    <td style="text-align: center"><input type="checkbox" <?= ($category['active']) ? 'checked' : '' ?>
                                                          disabled></td>
                </tr>
            <? endforeach; ?>
        </table>
    </div>
</div class="col-lg-12">