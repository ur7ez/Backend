<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 16.10.2017
 * Time: 19:24
 */
/*
На основе кода: https://github.com/Gendos-ua/academy_lessons/tree/master/05_practice_store

1. В административной части добавить возможность удаления категорий (рядом с названием ссылка "Удалить" или "х").
2. По аналогии с категориями реализовать управление товарами - при добавлении товара мы можем указать его название, цену и категорию (выбор через выпадающий список из существующих категорий). При нажатии на строку товара - появляется форма редактирования. Возле каждого товара - ссылка на удаление.
3. Защитить административную часть сайта при помощи HTTP basic авторизации.
4. Избавиться от повторения кода в `index.php` и `admin.php`. Например можно в `admin.php` реализовать саму авторизацию, а уже авторизированным пользователям внутри `admin.php` подключать (`include`) `index.php` (само собой с измененной переменной `$incPath`).
5. Реализовать постраничную навигацию в админке для списка категорий/товаров.
*/

$localDir = (isset($localDir))? $localDir : 'public';
include_once('lib/core.php');
//$incPath = $_SERVER['DOCUMENT_ROOT'] . DS . 'Internet_store' . DS . 'inc' . DS . 'public';
$incPath = __DIR__ . DS . 'inc' . DS . $localDir;

$page = 'main';
if ($_GET['page']) {
    $page = str_replace(DS, '', $_GET['page']);
}

ob_start();

include($incPath . DS . 'header.php');
if (!include($incPath . DS . $page . ".php")) {
    echo '404';
    echo "<br>" . $incPath . DS . "$page.php";
}
include($incPath . DS . 'footer.php');

echo ob_get_clean();
