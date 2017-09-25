<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 20.09.2017
 * Time: 20:55
 */
//$_SERVER['REQUEST_URI']
$file = str_replace('/', DIRECTORY_SEPARATOR, $_GET['name']);
readfile(".." . $file);
