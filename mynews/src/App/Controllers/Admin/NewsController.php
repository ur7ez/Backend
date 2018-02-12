<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 20.11.2017
 * Time: 19:33
 */

namespace App\Controllers\Admin;

use App\Controllers\Base;
use App\Core\App;
use App\Core\Pagination;
use App\Entity\News;

class NewsController extends Base
{
    /** @var News */
    private $newsModel;

    public function __construct($params = [])
    {
        parent::__construct($params, 20);
        $this->newsModel = new News(App::getConnection());
    }

    public function indexAction()
    {
        $param = $this->params;
        $page = isset($param['query']['page']) ? (int)$param['query']['page'] : 1;
        $itemsCount = 0;

        $this->data['news'] = $this->newsModel->list(
            [],
            $this->itemsPerPage,
            $this->itemsPerPage * ($page - 1),
            1,
            [],
            $itemsCount
        );

        $this->data['pagination'] = new Pagination([
            'itemsCount' => $itemsCount,
            'itemsPerPage' => $this->itemsPerPage,
            'currentPage' => $page
        ]);
    }

    public function editAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $id = isset($this->params[0]) ? $this->params[0] : null;
                $this->data = [
                    'title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'active' => $_POST['active'],
                    'new' => true,
                ];
                $this->newsModel->save($this->data, $id);
                App::getSession()->setFlash('Page has been saved');
                App::getRouter()->redirect('index');
            } catch (\Exception $e) {
                App::getSession()->setFlash($e->getMessage());
            }
        }
        if (isset($this->params[0]) && $this->params[0] > 0) {
            $this->data = $this->newsModel->getById($this->params[0]);
        }
    }

    public function deleteAction()
    {
        $id = isset($this->params[0]) ? $this->params[0] : null;
        if (!$id) {
            App::getSession()->setFlash('Missing page id');
        } elseif ($this->newsModel->delete($id)) {
            App::getSession()->setFlash('Page has been deleted');
        } else {
            App::getSession()->setFlash('Couldn\'t delete page');
        }
        App::getRouter()->redirect('index');
    }
}