<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/6/17
 * Time: 19:25
 */

namespace App\Controllers;

use App\Core\App;
use App\Entity\Page;

class PagesController extends Base
{
    /** @var Page */
    private $pageModel;

    public function __construct($params = [])
    {
        parent::__construct($params);

        $this->pageModel = new Page(App::getConnection());
    }

    public function indexAction()
    {
        $this->data = $this->pageModel->list(['active' => 1]);
    }

    public function viewAction()
    {
        $page = $this->pageModel->getById($this->params[0]);

        if (!empty($page) && $page['active']) {
            $this->data = $page;
        } else {
            $this->page404();
        }
    }
}