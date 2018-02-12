<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 2/5/18
 * Time: 20:10
 */

/**
 * @var array $data from \App\Views\Base::render()
 * @var \App\Core\Router $router from \App\Core\App::getRouter()
 */

if (!empty($data['select_info'])) {
    $currentTagID = -1;
    $hide_class = '';
} else {
    $currentTagID = $data['news'][0]['tag_id'];
    $hide_class = ' d-none';
}
?>
<nav class="col-12 col-md-3 col-xl-2 px-1 d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <span><strong>Тэги новостей:</strong></span>
            <? foreach ($data['tags'] as $tag): ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($tag['id'] === $currentTagID) ? 'active' : '' ?>"
                       href="<?= $router->buildUri('index', [$tag['id']]) ?>">
                        <i class="far fa-arrow-alt-circle-right feather"></i>
                        <?= $tag['tag'] ?><span
                                class="sr-only"><?= ($tag['id'] === $currentTagID) ? '(current)' : '' ?></span></a>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
</nav>

<div class="col-md-9 col-xl-10 ml-sm-auto">
    <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded box-shadow">
        <img class="mr-3" src="/categories_img/default.png" alt="cap-image" width="100">
        <div class="lh-100">
            <h3><?= (!empty($data['select_info'])) ? $data['select_info'] : $data['news'][0]['tag'] ?></h3>
            <small><strong><?= $data['count_all'] ?></strong> новостей в по тэгу</small>
        </div>
    </div>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0"><strong>Новости по тэгам:</strong></h6>
        <? foreach ($data['news'] as $news): ?>

            <div class="media text-muted pt-3">
                <img alt="32x32" class="mr-2 rounded" style="width: 32px; height: 32px;"
                     src="/img/box<?= rand(1, 4) ?>.svg">
                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <strong class="d-block text-gray-dark">
                            <a href="<?= $router->buildUri('news.view', [$news['id']]) ?>"><?= $news['title'] ?></a>
                        </strong>
                        <span class="<?= $hide_class ?>"><strong><a
                                        class="text-warning"
                                        href="<?= $router->buildUri('tags.index', [$news['tag_id']]) ?>"
                                        title="все новости по тэгу"><?= $news['tag'] ?></a></strong></span>
                    </div>
                    <span class="d-block">Дата публикации: <?= DateTime::createFromFormat(
                            'Y-m-d H:i:s', $news['date_created'])
                            ->format('Y-m-d H:i') ?></span>
                    <span class="d-block">Автор: <em><?= $news['author'] ?></em></span>
                    <span class="d-block"><a href="http://www.<?= $news['source_ref'] ?>" title="первоисточник новости">Источник</a></span>
                </div>
            </div>
        <? endforeach; ?>
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
</div>