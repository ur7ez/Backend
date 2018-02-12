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

$category_arr = array_column($data['categories'], 'title', 'id');
$ads = $data['ads_data'];
$ads_cnt = 5;
$ads_bg_cnt = count($data['ads_background']);
?>
<!--  Carousel heredown  -->
<div class="container">
    <div id="myCarousel" class="carousel slide mx-5" data-ride="carousel">
        <ol class="carousel-indicators" style="cursor: pointer; bottom: 0">
            <? for ($i = 0, $j = 0; $i < count($data['news_in_categories']); $i += 5, $j++): ?>
                <li data-target="#myCarousel"
                    data-slide-to="<?= $j ?>"<?= ($i == 0) ? ' class="active"' : '' ?>>
                </li>
            <? endfor; ?>
        </ol>

        <div class="carousel-inner">
            <? for ($i = 0; $i < count($data['news_in_categories']); $i += 5): ?>
                <div class="carousel-item<?= ($i == 0) ? ' active' : '' ?>">
                    <div class="container">
                        <div class="card-group">
                            <img class="card-img-overlay first-slide" src="/categories_img/default.png" alt="slide img">
                            <div class="carousel-caption d-none d-md-block card-body">
                                <div class="card-title">
                                    <strong class="d-inline-block mb-2 text-success"><?= $category_arr[$data['news_in_categories'][$i]['category_id']] ?>
                                    </strong>
                                </div>
                                <div class="mb-1"><?= DateTime::createFromFormat(
                                        'Y-m-d H:i:s',
                                        $data['news_in_categories'][$i]['date_created'])
                                        ->format('Y-m-d') ?></div>
                                <p class="card-text mb-auto"><?= $data['news_in_categories'][$i]['title'] ?></p>
                                <a href="<?= $router->
                                buildUri('news.view',
                                    [$data['news_in_categories'][$i]['id']]) ?>">Читать далее</a>
                            </div>
                        </div>
                    </div>
                </div>
            <? endfor; ?>
        </div>

        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!--  Advertisements block  -->
<div class="col-lg-2 px-1">
    <? $ads_rnd = array_rand($data['ads_data'], $ads_cnt);
    foreach ($ads_rnd as $ads) :
        $bg = $data['ads_background'][rand(0, $ads_bg_cnt - 1)];
        ?>
        <div class="card text-<?= ($bg == 'white' || $bg == 'light') ? 'dark' : 'white' ?> bg-<?= $bg ?> mb-3 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal text-center"><?= $data['ads_data'][$ads]['product'] ?></h4>
            </div>
            <div class="card-body p-2">
                <h1 class="card-title text-center"><?= $data['ads_data'][$ads]['price'] ?>
                    <small class="<?= ($bg == 'secondary') ? '' : 'text-muted' ?>">грн/ед.</small>
                </h1>
                <span><?= $data['ads_data'][$ads]['description'] ?></span>
                <button type="button"
                        class="btn btn-sm btn-block<?= ($bg == 'white' || $bg == 'light') ? '' : ' btn-light' ?>"><a
                            href="<?= $data['ads_data'][$ads]['ref'] ?>" target="_blank">Перейти</a></button>
            </div>
            <div class="card-footer bg-transparent">
                <?= $data['ads_data'][$ads]['seller'] ?>
            </div>
        </div>
    <? endforeach; ?>
</div>

<!--  Main content  -->
<div class="col-lg-8">
    <div class="d-flex align-items-center p-3 mb-3 text-white-50 bg-purple rounded box-shadow">
        <img class="mr-3" src="/img/logo.svg" alt="" width="48" height="48">
        <div class="lh-100">
            <h6 class="mb-0 text-white lh-100"><?= __('main.welcome') ?></h6>
            <small>Since 2018</small>
        </div>
    </div>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <? foreach ($data['categories'] as $category): ?>
            <h6 class="border-bottom border-gray pb-2 mb-0 text-capitalize">
                <strong>
                    <a href="<?= $router->buildUri('news.index', [$category['id']]) ?>"><?= $category['title'] ?></a>
                </strong>
            </h6>
            <!--    Заголовки новостей в данной категори    -->
            <?
            $news_filtered = \App\Entity\Category::filterArrayFromID(
                $data['news_in_categories'], 'category_id', $category['id']);
            foreach ($news_filtered as $news): ?>
                <div class="media text-muted pt-3">
                    <img alt="32x32" class="mr-2 rounded" style="width: 32px; height: 32px;"
                         src="/img/box<?= rand(1, 4) ?>.svg"
                         data-holder-rendered="true">
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">
                            <a href="<?= $router->buildUri('news.view', [$news['id']]) ?>"><?= $news['title'] ?></a></strong>
                        <?= DateTime::createFromFormat(
                            'Y-m-d H:i:s', $news['date_created'])
                            ->format('Y-m-d H:i') ?>
                    </p>
                </div>
            <? endforeach; ?>
            <!--    Заголовки новостей в данной категори    -->
            <small class="d-block text-right mt-3">
                <a href="<?= $router->buildUri('news.index', [$category['id']]) ?>">
                    Все <?= $category['description'] ?></a>
            </small>
        <? endforeach; ?>
    </div>
</div>

<!--  right top aggregates -->
<div class="col-lg-2 px-1">
    <div class="card border-secondary mb-3" style="max-width: 18rem;">
        <div class="card-body text-secondary p-2 text-center">
            <h5 class="card-header">ТОП-5 активных тем</h5>
            <div class="card-body px-0 py-1">
                <? foreach ($data['top_commented_news'] as $top_commented): ?>
                    <a href="<?= $router->buildUri('news.view', [$top_commented['news_id']]) ?>"
                       class="card-text d-block text-truncate px-1"
                       title="дата создания: <?= $top_commented['date_created'] . PHP_EOL ?>кол-во комментариев: <?= $top_commented['comments_cnt'] ?>"><?= $top_commented['title'] ?></a>
                <? endforeach; ?>
            </div>
        </div>
    </div>
    <div class="card border-info mb-3" style="max-width: 18rem;">
        <div class="card-body text-info p-2 text-left">
            <h5 class="card-header text-center">Активные <em class="text-nowrap">комментаторы</em></h5>
            <div class="card-body px-0 py-1">
                <div class="card-text">
                    <? foreach ($data['top_active_users'] as $topUsers): ?>
                        <p class="my-1"><a href="<?= $router->buildUri('users.index', [$topUsers['user_id']]) ?>"
                                           class="card-text"
                                           title="написал <?= $topUsers['comments_cnt'] . ' комментариев и получил ' .
                                           PHP_EOL . $topUsers['likes'] . ' лайков и ' . $topUsers['dislikes'] . ' хейтов...' ?>"><?= $topUsers['user_name'] ?></a>
                            <small><?= ' (' . $topUsers['comments_cnt'] . ')' ?></small>
                        </p>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>