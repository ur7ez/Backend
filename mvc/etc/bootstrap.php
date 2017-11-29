<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/6/17
 * Time: 19:14
 */

include_once ROOT . DS . 'etc' . DS . 'config.php';
include_once ROOT . DS . 'etc' . DS . 'functions.php';

ini_set('display_errors', App\Core\Config::get('debug') ? 1 : 0);
