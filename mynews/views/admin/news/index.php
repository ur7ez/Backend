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
<h1 class="text-info mx-auto"><?= __('admin.news_mgmt') ?></h1>

<div class="col-lg-12">
    <div>
        <a class="btn btn-success"
           href="<?= $router->buildUri('edit') ?>"><?= __('admin.create_newspage') ?></a>
    </div>

    <ul class="list-group">
        <li class="list-group-item active"><?= __('main.news_list') ?></li>
        <? foreach ($data['news'] as $news): ?>
            <li class="list-group-item">
                <a class="btn btn-success btn-sm"
                   href="<?= $router->buildUri('edit', [$news['id']]) ?>"><?= __('general.edit') ?></a>
                <a class="btn btn-sm btn-warning" onclick="return confirmDelete();"
                   href="<?= $router->buildUri('delete', [$news['id']]) ?>"><?= __('general.delete') ?></a>
                <?= $news['title'] ?>
            </li>
        <? endforeach; ?>
    </ul>

    <!--        Pagination -->
    <small class="d-block text-right mt-3">
        <nav aria-label="Page navigation" class="navbar-text">
            <ul class="pagination px-5">
                <?php $cnt = 0;
                foreach ($data['pagination']->buttons as $button) :
                    if ($cnt == 1) : ?>
                        <li class="page-item show-other-pages order-2"><span class="page-link"> ... </span></li>
                        <div class="card-deck btn-group-vertical paging mx-auto order-3">
                    <? endif;
                    if ($cnt == count($data['pagination']->buttons) - 1) : ?>
                        </div>
                    <? endif; ?>
                    <? if ($button->isActive) : ?>
                    <li class="page-item">
                        <a class="page-link" href='?page=<?= $button->page ?>'><?= $button->text ?></a>
                    </li>
                <?php else : ?>
                    <li class="page-item<?= ($button->isCurrent) ? ' active' : ' disabled' ?>">
                        <span class="page-link"><?= $button->text ?></span>
                    </li>
                <?php endif;
                    $cnt++;
                endforeach; ?>
            </ul>
        </nav>
    </small>
</div>
