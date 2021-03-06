<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 19.11.2017
 * Time: 1:36
 */

namespace App\Controllers;

use App\Core\App;
use App\Core\Config;
use App\Core\Session;
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

    public function registerAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            $data = $_POST;
            if (!strlen($data['password']) || $data['password'] !== $data['password_cfm']) {
                App::getSession()->setFlash('Failed password integrity check');
            } else {
                if ($this->usersModel->register($data)) {
                    App::getSession()->setFlash('Thank you for registration!');
                    App::getRouter()->redirect('users.login');
                } else {
                    App::getSession()->setFlash(
                        'User with login \'' . $data['login'] . '\' already exists.
                     Choose another login or use <a href="' . App::getRouter()->buildUri('users.login') . '">Sign-in form</a>.');
                }
            }
        }
    }

    public function loginAction()
    {
        if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
            $user = $this->usersModel->getByLogin($_POST['login']);
            $hash = md5(Config::get('sault') . $_POST['password']);
            if ($user && $user['active']) {
                if ($user && $user['active'] && $hash == $user['password']) {
                    App::getSession()->set('login', $user['login']);
                    App::getSession()->set('role', $user['role']);
                    App::getSession()->set('email', $user['email']);
                    App::getSession()->setFlash('User \'' . $user['login'] . '\' logged in successfully.');
                    if ($user['role'] === 'admin') {
                        App::getRouter()->redirect('admin.pages.index');
                    } else {
                        App::getRouter()->redirect('pages.index');
                    }
                } else {
                    App::getSession()->setFlash('Incorrect user login or password. Enter correct data');
                }
            } else {
                App::getSession()->setFlash('user \'' . $user['login'] . '\' is deactivated by administrator');
            }
        }
    }

    public function logoutAction()
    {
        $curUser = App::getSession()->get('login');
        App::getSession()->destroy();
        App::getSession()->setFlash('User \'' . $curUser . '\' logged out successfully.');
        App::getRouter()->redirect('users.login');
    }
}