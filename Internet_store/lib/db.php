<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 16.10.2017
 * Time: 20:02
 */

$dbHost = 'localhost';
$dbUser = 'goods';
$dbPassword = 'goods';
$dbName = 'goods';

$connection = mysqli_connect(
    $dbHost,
    $dbUser,
    $dbPassword,
    $dbName
);
$connection->query('SET NAMES utf8;');
$connection->query('SET CHARSET utf8;');

$tablesMap = [
    'category' => 'category',
    'product' => 'product',
];
