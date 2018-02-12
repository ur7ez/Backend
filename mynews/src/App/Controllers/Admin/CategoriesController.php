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
use App\Entity\Category;

class CategoriesController extends Base
{
    /** @var Category */
    private $categoryModel;

    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->categoryModel = new Category(App::getConnection());
    }

    public function indexAction()
    {
        $this->data = $this->categoryModel->list();
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
                $this->categoryModel->save($this->data, $id);
                App::getSession()->setFlash('Page has been saved');
                App::getRouter()->redirect('index');
            } catch (\Exception $e) {
                App::getSession()->setFlash($e->getMessage());
            }
        }
        if (isset($this->params[0]) && $this->params[0] > 0) {
            $this->data = $this->categoryModel->getById($this->params[0]);
        }
    }

    public function deleteAction()
    {
        $id = isset($this->params[0]) ? $this->params[0] : null;
        if (!$id) {
            App::getSession()->setFlash('Missing page id');
        } elseif ($this->categoryModel->delete($id)) {
            App::getSession()->setFlash('Page has been deleted');
        } else {
            App::getSession()->setFlash('Couldn\'t delete page');
        }
        App::getRouter()->redirect('index');
    }
}