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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if (!strlen($data['password']) || $data['password'] !== $data['password_cfm']) {
                Session::setFlash('Failed password integrity check.');
                return false;
            }
            array_pop($data);
            if ($data) {
                if ($this->usersModel->register($data)) {
                    //  TODO: сообщение не выводится ...
                    Session::setFlash('Thank you for registration!');
                    App::getRouter()->redirect('users.login');
                } else {
                    Session::setFlash(
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
            if ($user && $user['active'] && $hash == $user['password']) {
                Session::set('login', $user['login']);
                Session::set('role', $user['role']);
                //  TODO: сообщение не выводится ...
                Session::setFlash($user['login'] . ' logged in successfully.');
                App::getRouter()->redirect('pages.index');
            } else {
                Session::setFlash('Incorrect user login or password. Enter correct data.');
            }
        }
    }

    public function logoutAction()
    {
        $curUser = Session::get('login');
        Session::destroy();
        //  TODO: сообщение не выводится ...
        Session::setFlash('User \'' . $curUser . '\' logged out successfully.');
        App::getRouter()->redirect('users.login');
    }
}