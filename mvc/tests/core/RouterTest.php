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
     * @param $controller
     * @param $action
     * @param $params
     * @dataProvider additionProvider
     */
    public function testInitialization($uri, $controller, $action, $params)
    {
        $router = new \App\Core\Router($uri);

        $this->assertEquals(Config::get('defaultLanguage'), $router->getLang());
        $this->assertEquals(Config::get('defaultRoute'), $router->getRoute());
        $this->assertEquals($controller, $router->getController());
        $this->assertEquals($action, $router->getAction());
        $this->assertEquals($params, $router->getParams());
    }

//    public function testBuildingUri (){
//
//    }

    public function additionProvider()
    {
        return [
            ['/user/auth/1', 'UserController', 'authAction', ['1']],
        ];
    }
}