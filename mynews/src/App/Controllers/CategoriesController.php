<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/6/17
 * Time: 19:25
 */

namespace App\Controllers;

use App\Core\App;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Ads;

class CategoriesController extends Base
{
    /** @var Category */
    private $categoryModel;
    private $commentsModel;
    private $adsModel;

    public function __construct($params = [])
    {
        parent::__construct($params);

        $this->categoryModel = new Category(App::getConnection());
        $this->commentsModel= new Comment(App::getConnection());
        $this->adsModel = new Ads(App::getConnection());
    }

    public function indexAction()
    {
        $this->data = $this->adsModel->list(['active' => 1]);
        $this->data['categories'] = $this->categoryModel->list(['active' => 1]);
        $this->data['news_in_categories'] = $this->categoryModel->listTop();
        $this->data['top_commented_news'] = $this->commentsModel->listTopCommentedNews();
        $this->data['top_active_users'] = $this->commentsModel->listTopCommentingUsers();
    }

    public function viewAction()
    {
        $category = $this->categoryModel->getById($this->params[0]);

        if (!empty($category) && $category['active']) {
            $this->data = $category;
        } else {
            $this->page404();
        }
    }
}