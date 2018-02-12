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
use App\Entity\News;
use App\Entity\Tags;

class TagsController extends Base
{
    /** @var tags */
    private $tagsModel;
    /** @var news */
    private $newsModel;

    public function __construct($params = [])
    {
        parent::__construct($params);

        $this->tagsModel = new Tags(App::getConnection());
        $this->newsModel = new News(App::getConnection());
    }

    public function indexAction()
    {
        $param = $this->params;
        $page = isset($param['query']['page']) ? (int)$param['query']['page'] : 1;
        $itemsCount = 0;

        $this->data['tags'] = $this->tagsModel->list(['active' => 1], null, 0, 1);
        if (empty($param[0])) {
            $this->data['news'] = $this->tagsModel->list(
                ['active' => 1],
                $this->itemsPerPage,
                $this->itemsPerPage * ($page - 1),
                0,
                ['date_created' => -1],
                $itemsCount
            );
            $this->data['select_info'] = 'Последние новости для всех тэгов';
        } else {
            $this->data['news'] = $this->tagsModel->list(
                ['active' => 1, 'tag_id' => $param[0]],
                $this->itemsPerPage,
                $this->itemsPerPage * ($page - 1),
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

    }
}