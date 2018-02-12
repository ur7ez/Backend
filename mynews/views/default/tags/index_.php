<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 2/5/18
 * Time: 20:10
 */

/**
 * Это вариант страницы с пагинацией и выводом новостей на Ангуляре
 *
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
$itemsPerPage = $data['itemsPerPage'];
$pagesCount = ceil($data['count_all'] / $itemsPerPage) - 1;
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
    <div class="my-3 p-3 bg-white rounded box-shadow" data-ng-controller="myCtrl">
        <h6 class="border-bottom border-gray pb-2 mb-0"><strong>Новости по тэгам:</strong></h6>

        <div class="media text-muted pt-3"
             data-ng-repeat="newsObj in data | limitTo : <?= $itemsPerPage ?> : (<?= $itemsPerPage ?> * page)"
             data-ng-init="rand = getRandom()">
            <img alt="32x32" class="mr-2 rounded" style="width: 32px; height: 32px;"
                 src="/img/box{{rand}}.svg">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <strong class="d-block text-gray-dark">
                        <a href="/news/view{{newsObj.id}}/">{{newsObj.title}}</a>
                    </strong>
                    <span class="<?= $hide_class ?>"><strong><a
                                    class="text-warning"
                                    href="/tags/index/{{newsObj.tag_id}}"
                                    title="все новости по тэгу">{{newsObj.tag}}</a></strong></span>
                </div>
                <span class="d-block">Дата публикации: {{newsObj.date_created}}</span>
                <span class="d-block">Автор: <em>{{newsObj.author}}</em></span>
                <span class="d-block"><a href="http://www.{{newsObj.source_ref}}"
                                         title="первоисточник новости">Источник</a></span>
            </div>
        </div>
        <!-- Pagination -->
        <small class="d-block text-right mt-3">
            <button data-ng-click="prevPage(page)" data-ng-disabled="page==0">
                Предыдущая
            </button>
            <button data-ng-click="nextPage(page, <?= $pagesCount ?>)"
                    data-ng-disabled="page==<?= $pagesCount ?>">
                Следующая
            </button>
        </small>
    </div>
</div>
