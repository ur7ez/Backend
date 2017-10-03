<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.09.2017
 * Time: 19:39
 */

//На основе материала урока (https://github.com/Gendos-ua/academy_lessons/tree/master/04_practice) реализовать следующий
// функционал (https://github.com/Gendos-ua/academy_lessons/blob/master/04_headers/homework_2.md):

//1. Создать отдельную страницу (в директории `inc`) для вывода формы регистрации. Добавить ссылку на эту страницу под форму входа. В форме три поля - Логин, Пароль, Подтверждение пароля. Убедиться, что неавторизованный пользователь может зарегистрироваться. Список пользователей хранить в отдельом файле в директории `config` (или создать отдельную) в сериализованном виде. Пароль в открытом виде храниться не должен, храним только контрольную сумму (`sha1` или `md5`) с добавлением примеси (`$salt`). В массив конфигурации в `config/global.php` в ключ `users` записывать массив, полученный из этого файла.

//2. Реализовать работу формы входа. Если человек не авторизован, он может открыть только две страницы - вход и регистрация. После успешной проверки логина/пароля сохранять результат авторизации в `$_SESSION['auth']`, так же в сессии сохранить логин вошедшего пользователя.

//3. В шапку сайта (`header.php`) добавить приветствие пользователя в формате `Привет {{login}}`. Логин подставляем уже после выполнения файла при помощи буферизации вывода - в самом файле вместо логина подставляем шаблон - `{{login}}` а в `index.php` на место этого шаблона вставляем реальный логин.

session_start();
define('DS', DIRECTORY_SEPARATOR);
ini_set('display_errors', 1);
$users_file = 'config' . DS . 'users.dat';
$config = require 'config' . DS . 'global.php';

ob_start();
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
              integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ"
              crossorigin="anonymous">
        <title>Hello world</title>
    </head>
    <body>
    <?php
    $page = 'main';
    if (!empty($_GET['page'])) {
        $page = $_GET['page'];
    }
    if (!empty($_GET['logout'])) {
        unset($_SESSION['auth']);
        unset($_SESSION['login']);
    }
    // Если человек не авторизован - показываем только форму входа / регистрации
    if (!isset($_SESSION['auth']) && $page != 'register') {
        $page = 'auth'; //$page = 'register';
    }
    $parts = ['header', $page, 'footer',];
    foreach ($parts as $part) {
        ob_start();
        include 'inc' . DS . $part . '.php';
        if ($part == 'header') {
            $partContent = str_ireplace('{{basket}}', "В корзине 3 товара", ob_get_clean());
            if (isset($_SESSION['login'])) {
                $partContent = str_ireplace('{{login}}', $_SESSION['login'], $partContent);
            } else {
                $partContent = str_ireplace('Привет {{login}}', '', $partContent);
            }
        } else {
            $partContent = ob_get_clean();
        }
        echo $partContent;
    }
    ?>
    </body>
    </html>
<?php
$pageContent = ob_get_clean();
echo $pageContent;
