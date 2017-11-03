<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 16.10.2017
 * Time: 19:24
 */
$localDir = (isset($localDir)) ? $localDir : 'public';

spl_autoload_register(function ($name) {
    $name = str_replace('\\', DS, $name);
//    var_dump($name);
    include_once $name . '.php';
});
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
