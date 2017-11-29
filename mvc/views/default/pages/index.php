<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/6/17
 * Time: 20:10
 */

/** @var array $data from \App\Views\Base::render() */
?>
<div class="col-lg-12">
    <h1><?= __('main.welcome') ?></h1>
</div>

<div class="col-lg-12">
    <ul class="list-group">
        <li class="list-group-item active"><?= __('main.pages_list') ?></li>
        <? foreach ($data as $page): ?>
            <li class="list-group-item">
                <a href="<?= \App\Core\App::getRouter()->buildUri('view', [$page['id']]) ?>"><?= $page['title'] ?></a>
            </li>
        <? endforeach; ?>
    </ul>
</div>
