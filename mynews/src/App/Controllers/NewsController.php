<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 11/6/17
 * Time: 19:25
 */

namespace App\Controllers;

use App\Core\App;
use App\Core\Pagination;
use App\Entity\Category;
use App\Entity\News;
use App\Entity\Tags;

class NewsController extends Base
{
    /** @var news */
    private $newsModel;
    /** @var tags */
    private $tagsModel;

    public function __construct($params = [])
    {
        parent::__construct($params);

        $this->newsModel = new News(App::getConnection());
        $this->tagsModel = new Tags(App::getConnection());
    }

    public function indexAction()
    {
        $categoryModel = new Category(App::getConnection());
        $param = $this->params;
        $page = isset($param['query']['page']) ? (int)$param['query']['page'] : 1;
        $itemsCount = 0;

        $this->data['categories'] = $categoryModel->list(['active' => 1]);
        if (empty($param[0])) {
            $this->data['news'] = $this->newsModel->list(
                ['active' => 1],
                $this->itemsPerPage,
                $this->itemsPerPage *  ($page - 1),
                0,
                ['news_date_created' => -1],
                $itemsCount
            );
            $this->data['select_info'] = 'Последние новости всех категорий';
        } else {   // только новости в указанной категории
            $this->data['news'] = $this->newsModel->list(
                ['active' => 1, 'category_id' => $param[0]],
                $this->itemsPerPage,
                $this->itemsPerPage *  ($page - 1),
                0,
                [],
                $itemsCount
            );
        }
        $this->data['count_all'] = $itemsCount;

        $this->data['pagination'] = new Pagination([
            'itemsCount' => $itemsCount,
            'itemsPerPage' => $this->itemsPerPage,
            'currentPage' => $page
        ]);
    }

    public function viewAction()
    {
        $news = $this->newsModel->getById($this->params[0], 1, 1);
        if (!empty($news) && $news['active']) {
            $this->data['news_content'] = $news;

            // передаем также все категории, в которых находится новость
            $this->data['news_categories'] = $this->newsModel->list(['news_id' => $this->params[0]]);

            // передаем также все тэги связанные с данной новостью:
            $tags = $this->tagsModel->getById($this->params[0], 0);
            $this->data['news_tags'] = $tags;

            // обновляем кол-во хитов новости:
            $new_hits = rand(1, 6);
            $this->data['readers_online'] = $new_hits;
            $new_hits += $news['hits_cnt'];

            //update news hits_cnt with readers online value generated above
            $this->newsModel->save(
                ['hits_cnt' => $new_hits],
                $this->params[0],
                1);
        } else {
            $this->page404();
        }
    }
}