<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 16.10.2017
 * Time: 20:06
 */

use App\Main\Config;

ini_set('display_errors', 1);
error_reporting(1);

define('DS', DIRECTORY_SEPARATOR);
$errors = [];
$config = new Config();