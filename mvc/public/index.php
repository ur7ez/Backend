<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/1/17
 * Time: 20:31
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

include(ROOT . DS . 'etc' . DS . 'bootstrap.php');
session_start();

try {
    $uri = $_SERVER['REQUEST_URI'];
//    echo '<pre>';
//    var_dump(parse_url($uri));
//    echo 'URI: '.$uri;
    App\Core\App::run($uri);
} catch (Exception $e) {
    if (App\Core\Config::get('debug')) {
        echo '<pre>', var_export($e, 1), '</pre>';
    } else {
        echo 'Something gone wrong...';
    }
}
