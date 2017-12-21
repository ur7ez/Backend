<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 19.12.2017
 * Time: 16:25
 */

echo '<pre>';

//1. Дана строка содержащая HTML. Получите все ссылки в этой строке в виде массива (значение атрибутов href="" и src=""). Учтите, что названия атрибутов может быть в разных регистрах, так же может быть пробел между названием и символом =.

//$str_ = file_get_contents('https://br3t.github.io/fstk/lesson/javascript_16/index.html');
$str = '<nav id="head-nav" class="navbar navbar-fixed-top">
  <div class="navbar-inner clearfix">
    <a href="/" class="brand"><img src="/images/logos/php-logo.svg" width="48" height="24" alt="php"></a>
    <div id="mainmenu-toggle-overlay"></div>
    <input type="checkbox" id="mainmenu-toggle">
    <ul class="nav">
      <li class=""><a href="/downloads">Downloads</a></li>
      <li class="active"><a href="/docs.php">Documentation</a></li>
      <li class=""><a href="/get-involved">Get Involved</a></li>
      <li class=""><a href="/support">Help</a></li>
    </ul>
    <form class="navbar-search" id="topsearch" action="/search.php">';
$matches = [];
$res = preg_match_all('/(href|src)\s*=\s*["\'](.*)["\']/iU', $str, $matches);
echo "Задача 1: ";
var_dump($matches[2]);

//2. Дана строка содержащая переменные PHP. Оберните все переменные в HTML тег <b>
//Примеры:
//текст $var текст > текст <b>$var</b> текст
//текст $data["key"] текст > текст <b>$data["key"]</b> текст

echo '<hr>';
echo "Задача 2:" . PHP_EOL;

$str2 = 'текст $var текст; текст $data["key"] текст';
$res2 = preg_replace(
    '/(\$[a-z_\x7f-\xff][a-z0-9_\x7f-\xff]*[\[\'"]*[a-z0-9_\x7f-\xff]*[\]\'"]*)/i',
    '<b>$1</b>', $str2);
echo $str2 . " => " . PHP_EOL . $res2 . PHP_EOL;

//3. Дана строка - ссылка на сайт, получить из нее домен.
//Примеры:
//https://site.com > site.com
//http://sub.some-site.com.ua/some/page.html > sub.some-site.com.ua

echo PHP_EOL . '<hr>';
echo "Задача 3:" . PHP_EOL;
$str3 = [
    'https://site.com',
    'http://sub.some-site.com.ua/some/page.html',
    'https://br3t.github.io/fstk/lesson/javascript_16/index.html',
];
foreach ($str3 as $key => $val) {
    $res3 = preg_match_all(
        '/(http|https|ftp){1}:\/\/([a-z0-9\._-][^\/\s\?]+)/i',
        $val, $matches);
    echo $val . ' => ' . '<b>' . $matches[2][0] . '</b>' . PHP_EOL;
}

//4. Замените в строке двойную звездочку на !, не трогая одиночные звездочки и те, которые состоят в группе больше двух
//Примеры:
//** some ** message * > ! some ! message *
//another *** message * > another *** message *

echo PHP_EOL . '<hr>';
echo "Задача 4:" . PHP_EOL;
$str4 = '** some ** message *; another *** message *';
$res4 = preg_replace('/((?<=[^*])|(^[.]*))[*]{2}(?=[^*])/i', '!', $str4);
echo $str4 . '<br>=><br><b>' . $res4 . '</b>' . PHP_EOL;

//5. Удалить идущие подряд (через пробел, 1 или больше) два и более одинаковых слова, причем так, чтобы не осталось лишних (двойных) пробелов. Считайте все слова состоящими из маленьких латинских букв.
//Примеры:
//we we are the the champions > we are the champions
//hello hello world > hello world

echo PHP_EOL . '<hr>';
echo "Задача 5:" . PHP_EOL;
$str5 = '1. we we are the the   the champions' . PHP_EOL . '2. hello hello world';
$res5 = preg_replace('/\b(\w+)(\W+\1\b)+/i', '$1', $str5);
echo $str5 . '<br>=><br><b>' . $res5 . '</b>' . PHP_EOL;