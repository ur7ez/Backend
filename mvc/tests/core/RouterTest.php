<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.11.2017
 * Time: 20:06
 */

use App\Core\Config;

class RouterTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @param $uri
     * @param $lang
     * @param $route
     * @param $controller
     * @param $action
     * @param $params
     * @dataProvider uriProvider
     */
    public function testInitialization($uri, $lang, $route, $controller, $action, $params)
    {
        $router = new \App\Core\Router($uri);
        $clean = false;
        if (!$clean) {
            $contrSuffix = 'Controller';
            $actionSuffix = 'Action';
        } else {
            $contrSuffix = '';
            $actionSuffix = '';
        }
        $this->assertEquals($lang, $router->getLang());
        $this->assertEquals($route, $router->getRoute());
        $this->assertEquals($controller . $contrSuffix, $router->getController($clean));
        $this->assertEquals($action . $actionSuffix, $router->getAction($clean));
        $this->assertEquals($params, $router->getParams());
    }

    public function uriProvider()
    {
        //  uri like: [lang = 'ru']/[route = 'default']/[Controller = 'Pages']/[action = 'index']/[params]
        $l = Config::get('defaultLanguage');
        $r = Config::get('defaultRoute');
        $c = Config::get('defaultController');
        $a = Config::get('defaultAction');

        return [
            'def all' => ['/', $l, $r, $c, $a, []],
            'def lng-admin-pages-views-param' => ['/admin/pages/view/5', $l, 'admin', $c, 'view', ['5']],
            'en-admin-pages-edit-param' => ['en/admin/pages/edit/3?q=dfdf', 'en', 'admin', $c, 'edit', ['3']],
            'def lng-admin' => ['/admin/', $l, 'admin', $c, $a, []],
            'def lng-admin-users-index' => ['/admin/users/index', $l, 'admin', 'Users', $a, []],
            'def lng-admin-users-edit-5' => ['en/admin/users/edit/5', 'en', 'admin', 'Users', 'edit', ['5']],
            'def lng/route-index' => ['/contacts/index', $l, $r, 'Contacts', $a, []],
            'def lng/route-user-login' => ['/user/login', $l, $r, 'User', 'login', []],
            'ru-def route-user-auth-param' => ['ru/user/auth/12', $l, $r, 'User', 'auth', ['12']],
            'en-def route-user-auth' => ['en/user/auth', 'en', $r, 'User', 'auth', []],
            'def lng-route-user-auth-param' => ['/user/auth/1', $l, $r, 'User', 'auth', ['1']],
        ];
    }

    /**
     * the current URI for which method buildUri() forms new relative URI*
     * @param $forUri
     * the result URI that should be returned by buildUri() method
     * @param $res
     * URI passed to buildUri() method
     * @param $uri
     * URI parameters array passed to buildUri() method
     * @param $param
     * @dataProvider buildUriProvider
     */
    public function testBuildingUri($forUri, $res, $uri, $param = [])
    {
        $router = new \App\Core\Router($forUri);
        $this->assertEquals($res, $router->buildUri($uri, $param));

    }

    public function buildUriProvider()
    {
        return [
            ['/', '/', '.'],
            ['/', '/Pages/view/5', 'view', ['5']],
            ['/', '/pages/view', 'pages.view'],
            ['/', '/Pages/pages', 'pages'],
            ['/', '/Pages/edit/5', 'edit', ['5']],
            ['/', '/Pages/admin', 'admin'],
            ['/', '/Pages/delete/2', 'delete', ['2']],
            ['/', '/Pages/contacts', 'contacts'],
            ['/', '/pages/index', 'pages.index'],
            ['/', '/admin/pages', 'admin.pages'],
            ['/', '/contacts/index', 'contacts.index'],
            ['/', '/users/login', 'users.login'],
            ['/', '/users/logout', 'users.logout'],
            ['/', '/users/register', 'users.register'],
            ['/', '/en/admin/users/index', 'en.admin.users.index'],
            ['/', '/admin/users/edit/5', 'admin.users.edit', ['5']],
            ['/', '/admin/users/delete/1', 'admin.users.delete', ['1']],
            ['/', '/admin/contacts', 'admin.contacts'],
            ['/', '/ru/admin/contacts', 'ru.admin.contacts'],

            ['pages', '/', '.'],
            ['pages', '/Pages/view/5', 'view', ['5']],
            ['pages', '/pages/view', 'pages.view'],
            ['pages', '/Pages/pages', 'pages'],
            ['pages', '/Pages/edit/5', 'edit', ['5']],
            ['pages', '/Pages/admin', 'admin'],
            ['pages', '/Pages/delete/2', 'delete', ['2']],
            ['pages', '/Pages/contacts', 'contacts'],
            ['pages', '/pages/index', 'pages.index'],
            ['pages', '/admin/pages', 'admin.pages'],
            ['pages', '/contacts/index', 'contacts.index'],
            ['pages', '/users/login', 'users.login'],
            ['pages', '/users/logout', 'users.logout'],
            ['pages', '/users/register', 'users.register'],
            ['pages', '/en/admin/users/index', 'en.admin.users.index'],
            ['pages', '/admin/users/edit/5', 'admin.users.edit', ['5']],
            ['pages', '/admin/users/delete/1', 'admin.users.delete', ['1']],
            ['pages', '/admin/contacts', 'admin.contacts'],
            ['pages', '/ru/admin/contacts', 'ru.admin.contacts'],

            ['users/login', '/', '.'],
            ['users/login', '/Users/view/5', 'view', ['5']],
            ['users/login', '/pages/view', 'pages.view'],
            ['users/login', '/Users/pages', 'pages'],
            ['users/login', '/Users/edit/5', 'edit', ['5']],
            ['users/login', '/Users/admin', 'admin'],
            ['users/login', '/Users/delete/2', 'delete', ['2']],
            ['users/login', '/Users/contacts', 'contacts'],
            ['users/login', '/pages/index', 'pages.index'],
            ['users/login', '/admin/pages', 'admin.pages'],
            ['users/login', '/contacts/index', 'contacts.index'],
            ['users/login', '/users/login', 'users.login'],
            ['users/login', '/users/logout', 'users.logout'],
            ['users/login', '/users/register', 'users.register'],
            ['users/login', '/en/admin/users/index', 'en.admin.users.index'],
            ['users/login', '/admin/users/edit/5', 'admin.users.edit', ['5']],
            ['users/login', '/admin/users/delete/1', 'admin.users.delete', ['1']],
            ['users/login', '/admin/contacts', 'admin.contacts'],
            ['users/login', '/ru/admin/contacts', 'ru.admin.contacts'],

            ['admin', '/admin', '.'],
            ['admin', '/admin/Pages/view/5', 'view', ['5']],
            ['admin', '/admin/pages/view', 'pages.view'],
            ['admin', '/admin/Pages/pages', 'pages'],
            ['admin', '/admin/Pages/edit/5', 'edit', ['5']],
            ['admin', '/admin/Pages/admin', 'admin'],
            ['admin', '/admin/Pages/delete/2', 'delete', ['2']],
            ['admin', '/admin/Pages/contacts', 'contacts'],
            ['admin', '/admin/pages/index', 'pages.index'],
            ['admin', '/admin/admin/pages', 'admin.pages'],   //interesting dependency from currect URI
            ['admin', '/admin/contacts/index', 'contacts.index'],
            ['admin', '/admin/users/login', 'users.login'],
            ['admin', '/admin/users/logout', 'users.logout'],
            ['admin', '/admin/users/register', 'users.register'],
            ['admin', '/en/admin/users/index', 'en.admin.users.index'],
            ['admin', '/admin/users/edit/5', 'admin.users.edit', ['5']],
            ['admin', '/admin/users/delete/1', 'admin.users.delete', ['1']],
            ['admin', '/admin/admin/contacts', 'admin.contacts'],   //interesting dependency from currect URI
            ['admin', '/ru/admin/contacts', 'ru.admin.contacts'],
        ];
    }
}