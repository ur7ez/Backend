<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 11/13/17
 * Time: 21:28
 */

/**
 * @var array $data from \App\Views\Base::render()
 * @var \App\Core\Router $router from \App\Core\App::getRouter()
 */
$session = \App\Core\App::getSession();

?>
<nav class="col-md-2 d-none px-1 d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <span><b>Похожие новости:</b></span>
        <ul class="nav flex-column">
            <? foreach ([1, 2, 3, 4, 5] as $news): ?>
                <li class="nav-item">
                    <a class="nav-link active"
                       href="<?= $router->buildUri('view', [rand(1, 900)]) ?>">
                        <i class="fa fa-icon"></i>Новость-<?= $news ?><span class="sr-only">(current)</span>
                    </a>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
</nav>
<article class="col-md-8 ml-sm-auto col-lg-8 pt-3 px-4 my-3 bg-white rounded box-shadow">
    <div class="blog-post">
        <h2 class="blog-post-title"><?= $data['news_content']['title'] ?></h2>
        <p class="blog-post-meta d-flex justify-content-between">
            <?= DateTime::createFromFormat(
                'Y-m-d H:i:s', $data['news_content']['date_created'])
                ->format('jS F Y \в H:i') ?>
            <span>by <em><?= $data['news_content']['author'] ?></em>
                <a href="http://www.<?= $data['news_content']['source_ref'] ?>"
                   title="первоисточник новости"> (Источник)</a></span>
        </p>
        <div class="text-center p-3">
            <img src="/content_img/default.jpg"
                 class="img-fluid rounded mx-auto d-block" alt="default title image" style="height: 300px">
        </div>

        <p>
            <? if (in_array('1', array_column($data['news_categories'], 'category_restricted'))
                && !$session->get('login')) :
                $str = $data['news_content']['content'];
                $matches = [];
                $res = preg_match_all('/["\']?[A-Z][^.?!]+((?![.?!][\'"]?\s["\']?[A-Z][^.?!]).)+[.?!\'"]+/iU', $str, $matches);
                $restricted = implode(array_slice($matches[0], 0, 5), ' ');
                ?>
                <?= $restricted ?> [...]
                <p>Полный текст новости доступен только для <a href="<?= $router->buildUri('users.login') ?>"><em>зарегистрированных</em></a> пользователей.</p>
            <? else: ?>
                <?= $data['news_content']['content'] ?>
            <? endif; ?>
        </p>
    </div>
    <p class="text-right">Оцените новость:
        <i class="far fa-thumbs-up"></i> / <i class="far fa-thumbs-down"></i>
    </p>
</article>

<aside class="col-md-2 pt-3">
    <div class="card border-primary mb-3" style="max-width: 18rem;">
        <div class="card-body text-primary p-2">
            <h5 class="card-header">О новости</h5>
            <p class="card-text">
                <span>Читают on-line: <strong><?= $data['readers_online'] ?></strong></span>
                <span>Всего просмотров: <strong><?= $data['news_content']['hits_cnt'] ?></strong></span>
            </p>
        </div>
    </div>
    <? if ($data['news_tags']): ?>
        <div class="card border-secondary mb-3" style="max-width: 18rem;">
            <div class="card-body text-secondary p-2 text-center">
                <h5 class="card-header">Тэги</h5>
                <div class="card-body px-0 py-1">
                    <? foreach ($data['news_tags'] as $tag): ?>
                        <a href="<?= $router->buildUri('tags.index', [$tag['tag_id']]) ?>"
                           class="card-link"><?= $tag['tag'] ?></a>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    <? endif; ?>
    <div class="card border-info mb-3" style="max-width: 18rem;">
        <div class="card-body text-info p-2 text-left">
            <h5 class="card-header">Категории</h5>
            <div class="card-body px-0 py-1">
                <? foreach ($data['news_categories'] as $category): ?>
                    <a href="<?= $router->buildUri('news.index', [$category['category_id']]) ?>"
                       class="card-text d-block<?= ($category['category_restricted'] == 1) ? ' font-italic text-danger' : '' ?>"><?= $category['category_title'] ?></a>
                <? endforeach; ?>
            </div>
        </div>
    </div>
</aside>