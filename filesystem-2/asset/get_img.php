<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 20.09.2017
 * Time: 20:55
 */

$file = $_GET['name'];
//$fileDir = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "gallery_files";
readfile($file);
