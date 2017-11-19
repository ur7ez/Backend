<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/6/17
 * Time: 19:06
 */

namespace App\Core;

use App\Core\DB\Connection;

class App
{
    /** @var DB\IConnection */
    private static $conn;

    /** @var Router */
    private static $router;

    /**
     * @return Router
     */
    public static function getRouter(): Router
    {
        return self::$router;
    }

    /**
     * @return DB\IConnection
     */
    public static function getConnection(): DB\IConnection
    {
        return self::$conn;
    }

    /**
     * @param $uri
     * @throws \Exception
     */
    public static function run($uri)
    {
        static::$router = new Router($uri);

        static::$conn = new Connection(
            Config::get('db.host'),
            Config::get('db.user'),
            Config::get('db.password'),
            Config::get('db.name')
        );

        $className = static::$router->getController();
        $action = static::$router->getAction();      // defining Controller method
        $params = static::$router->getParams();

        Localization::setLang(static::$router->getLang());
        Localization::load();

        $route = static::$router->getRoute();

        $controllerName = '\App\Controllers\\'
            . ($route !== Config::get('defaultRoute') ? 'Admin\\' : '')
            . $className;

        // @todo Show 404 page
        if (!class_exists($controllerName)) {
            throw new \Exception('Controller ' . $controllerName . ' not found');
        }

        if ($route == 'admin' && Session::get('role') != 'admin') {
            if ($action != 'loginAction') {
                static::$router->redirect('admin.users.login');
            }
        }

        /** @var \App\Controllers\Base $controller */
        $controller = new $controllerName($params);

        if (!method_exists($controller, $action)) {
            throw new \Exception('Action ' . $action . ' not found in ' . $controllerName);
        }

        if (!$controller instanceof \App\Controllers\Base) {
            throw new \Exception('Controller must extend Base class');
        }

        ob_start();

        $controller->$action();

        $view = new \App\Views\Base(
            $controller->getData(),
            $controller->getTemplate()
        );

        $content = $view->render();

        $layout = new \App\Views\Base(
            ['content' => $content],
            ROOT . DS . 'views' . DS . $route . '.php'
        );

        echo $layout->render();

        ob_end_flush();
    }


}