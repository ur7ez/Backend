<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.11.2017
 * Time: 17:58
 */

namespace App\Controllers\Admin;

use App\Controllers\Base;
use App\Core\App;
use App\Entity\User;

class UsersController extends Base
{
    /** @var User */
    private $usersModel;

    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->usersModel = new User(App::getConnection());
    }

    public function indexAction()
    {
        $this->data = $this->usersModel->list(
            [], 0, 0, 0, ['role' => -1, 'id' => 1]
        );
    }

    public function editAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $id = isset($this->params[0]) ? $this->params[0] : null;
                $this->data = [
                    'login' => $_POST['login'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role'],
                    'password' => $_POST['password'],
                    'active' => !$_POST['active'],
                ];
                $this->usersModel->save($this->data, $id);
                App::getSession()->setFlash('User data has been revised');
                App::getRouter()->redirect('index');
            } catch (\Exception $e) {
                App::getSession()->setFlash($e->getMessage());
            }
        }
        if (isset($this->params[0]) && $this->params[0] > 0) {
            $this->data = $this->usersModel->getById($this->params[0]);
        }
    }

    public function deleteAction()
    {
        $id = isset($this->params[0]) ? $this->params[0] : null;
        if (!$id) {
            App::getSession()->setFlash('Missing user id');
        } elseif ($this->usersModel->delete($id)) {
            App::getSession()->setFlash('User has been deleted');
        } else {
            App::getSession()->setFlash('Couldn\'t delete user');
        }
        App::getRouter()->redirect('index');
    }
}