<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 16.10.2017
 * Time: 19:42
 */

session_start();

function authenticate()
{
    header(
        'WWW-Authenticate: Basic realm="Protected area, only for admins"',
        false,
        401
    );
    header('HTTP/1.1 401 Unauthorized');
    die("Вы не авторизованы (не корректный логин/пароль) \n");
}

$valid_passwords = [
    "admin" => "admin",
    "Mike" => "ur7ez",
];
$valid_users = array_keys($valid_passwords);

$user = (isset($_SERVER['PHP_AUTH_USER'])) ? $_SERVER['PHP_AUTH_USER'] : "";
$password = (isset($_SERVER['PHP_AUTH_PW'])) ? $_SERVER['PHP_AUTH_PW'] : "";
$validated = (in_array($user, $valid_users)) && ($password == $valid_passwords[$user]);

if (!empty($_GET['logout']) && isset($_SESSION['auth'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['login']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . str_replace('?' . $_SERVER['QUERY_STRING'], '',$_SERVER["REQUEST_URI"]));
//    header('HTTP/1.1 401 Unauthorized', false);
    authenticate();
    die();
} else if (!$validated) {
    authenticate();
}
$_SESSION['auth'] = true;
$_SESSION['login'] = $_SERVER['PHP_AUTH_USER'];

$localDir = 'admin';
include('index.php');