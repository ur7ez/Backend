<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/1/17
 * Time: 21:01
 */

namespace App\Core;

class Router
{
    protected $lang;

    protected $route;

    protected $controller;

    protected $action;

    protected $params;

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param bool $clean
     * @return string
     */
    public function getController($clean = false)
    {
        return $this->controller . (!$clean ? 'Controller' : '');
    }

    /**
     * @param bool $clean
     * @return string
     */
    public function getAction($clean = false)
    {
        return $this->action . (!$clean ? 'Action' : '');
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function __construct(string $uri)
    {
        $this->lang = Config::get('defaultLanguage');
        $this->route = Config::get('defaultRoute');
        $this->controller = Config::get('defaultController');
        $this->action = Config::get('defaultAction');

        $parts = parse_url($uri);

        $pathParts = explode(
            '/',
            trim($parts['path'], '/')
        );

        if (current($pathParts) && in_array(current($pathParts), Config::get('languages'))) {
            $this->lang = array_shift($pathParts);
        }

        if (current($pathParts) && in_array(current($pathParts), Config::get('routes'))) {
            $this->route = array_shift($pathParts);
        }

        if (current($pathParts)) {
            $this->controller = ucfirst(array_shift($pathParts));
        }

        if (current($pathParts)) {
            $this->action = array_shift($pathParts);
        }

        $this->params = (!empty($pathParts) && $pathParts[0] === '') ? [] : $pathParts;
        if (!empty($parts['query'])) {
            $this->params['query'] = $_GET;
        }
    }

    /**
     * Builds uri
     *
     * @param $path - Format - lang.route.controller.action
     * @param $params - params array
     * @return string
     */
    public function buildUri($path, $params = [])
    {
        $parts = array_reverse(explode('.', $path));
        $default = [
            Config::get('defaultAction'),
            $this->getController(true),
            $this->getRoute() !== Config::get('defaultRoute') ? $this->getRoute() : '',
            $this->getLang() !== Config::get('defaultLanguage') ? $this->getLang() : '',
        ];

        $c = 0;
        $result = [];
        while ($c++ < 4) {
            $result[] = count($parts) ? array_shift($parts) : $default[$c - 1];
        }

        // prepare params
        $paramsString = count($params) ? '/' . implode('/', $params) : '';

        // remove empty parts
        $result = array_filter($result);

        return '/' . mb_strtolower(implode('/', array_reverse($result))) . $paramsString;
    }

    /**
     * @param $path
     * @param int $status
     */
    public function redirect($path, $status = 302)
    {
        header('Location: ' . $this->buildUri($path), true, $status);
//        die();
    }

}