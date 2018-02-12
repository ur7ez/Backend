<?php
/**
 * Created by PhpStorm.
 * User: Mike Nykytenko
 * Date: 11/6/17
 * Time: 19:25
 */

namespace App\Controllers\Admin;

use App\Controllers\Base;
use App\Core\App;
use App\Entity\Ads;

class AdsController extends Base
{
    /** @var Ads */
    private $adsModel;

    public function __construct($params = [])
    {
        parent::__construct($params);

        $this->adsModel = new Ads(App::getConnection());
    }

    public function indexAction()
    {
        $this->data = $this->adsModel->list(['active' => 1]);
    }

    public function editAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $id = isset($this->params[0]) ? $this->params[0] : null;
                $this->data = [
                    'product' => $_POST['product'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'seller' => $_POST['seller'],
                    'ref' => $_POST['ref'],
                    'active' => $_POST['active'],
                    'new' => true,
                ];
                $this->adsModel->save($this->data, $id);
                App::getSession()->setFlash('Data has been saved');
                App::getRouter()->redirect('index');
            } catch (\Exception $e) {
                App::getSession()->setFlash($e->getMessage());
            }
        }
        if (isset($this->params[0]) && $this->params[0] > 0) {
            $this->data = $this->adsModel->getById($this->params[0]);
        }
    }

    public function deleteAction()
    {
        $id = isset($this->params[0]) ? $this->params[0] : null;
        if (!$id) {
            App::getSession()->setFlash('Missing adv id');
        } elseif ($this->adsModel->delete($id)) {
            App::getSession()->setFlash('Advertisement has been deleted');
        } else {
            App::getSession()->setFlash('Couldn\'t delete advertisement');
        }
        App::getRouter()->redirect('index');
    }
}