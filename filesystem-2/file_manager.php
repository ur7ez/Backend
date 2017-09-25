<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 20.09.2017
 * Time: 21:05
 */

error_reporting(E_ALL ^ E_WARNING);
define('DS', DIRECTORY_SEPARATOR);

function delTree($dir)
{
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        if (is_dir($dir . DS . $file)) {
            delTree($dir . DS . $file);
        } else {
            if (!unlink($dir . DS . $file)) {
                return false;
            }
        }
    }
    return rmdir($dir);
}

// Определим корневую директорию
$base = $_SERVER['DOCUMENT_ROOT']; //__DIR__;

// Определяем путь выбранной директории относительно корня
$path = '';
$errors = [];

if (!empty($_GET['dir']) && !in_array($_GET['dir'], ['.', '/'])) {
    $path = $_GET['dir'];
}

// удаляем переданный по ссылке файл или директорию:
if (!empty($_GET['del'])) {
    $path = dirname($_GET['del']);
    $tmp_path = $base . $_GET['del'];

//    echo "<script> confirm('You are trying to delete a file/directory. Continue ?') </script>";
    if (is_dir($tmp_path)) {
        //удаляет также непустой каталог рекурсивно (со всеми файлами и подкаталогами)
        if (!delTree($tmp_path)) $errors[] = "Ошибка удаления непустого каталога: недостаточно прав";
    } else {
        if (!unlink($tmp_path)) $errors[] = "Ошибка удаления файла: недостаточно прав";
    }
}

$path = ($path == '\\') ? '' : $path;

// Переименование файла / директории: подготовка - запрос нового имени
if (!empty($_GET['old'])) {
    $show_rename_form = true;
    $old_name = $base . $path . DS . $_GET['old'];
} else {
    $show_rename_form = false;
}

// Собственно само переименование файла / директории:
if (!empty($_GET['new'])) {
    $new_name = $base . $path . DS . $_GET['new'];
    $old_name = $_GET['old_name'];
    if ($old_name === $new_name) {
        $errors[] = "Старое и новое имена совпадают!";
    } else {
// переименовываем переданный по ссылке файл или директорию:
        if (!rename($old_name, $new_name)) $errors[] = "Ошибка переименования каталога/файла: недостаточно прав или недопустимое имя";
    }
}
// Поступил запрос на редактирование .txt / .php (text/..) файла:

if (!empty($_GET['file'])) {
//    $resource = fopen($_GET['file'], "c+b");
    $file_content = file_get_contents($_GET['file']);
    if ($file_content===false) {
        $show_edit_form = false;
        $errors[] = "Ошибка чтения файла " . $_GET['file'];
    } else $show_edit_form = true;
//    fclose($resource);
} else {
    $show_edit_form = false;
}

//Пришел отредактированный контент переданного ранее файла:
if ($show_edit_form  && !empty($_POST['file_content'])) {
    if (file_put_contents($_POST['file'], $_POST['file_content']) === false) $errors[] = "Ошибка записи в файл";
    $show_edit_form =false;
}

// Получаем все файлы и директории из текущего пути
$files = scandir($base . $path);

// Очищаем от лишних элементов
$removeParts = ['.'];
if (!$path) {
    // Если мы в корне - удаляем еще и элемент родительской директории
    $removeParts[] = '..';
}
$files = array_diff($files, $removeParts);

// Формируем данные для вывода
$result = [];
foreach ($files as $file) {
    $name = $file;
    $absFile = $base . $path . DS . $file;
//$base . ((!$path) ? "" : DS) . $path . DS . $file;
    // Для директорий делаем имя со ссылкой
    if (is_dir($absFile)) {
        if ($file == '..') {
            // Ссылку "вверх" делаем на один элемент вложенности меньше
            $url = dirname($path);
        } else {
            $url = $path . DS . $name;
        }
        $name = "<a href=\"?dir={$url}\">{$name}</a>";
    }

    // Добавляем текущий элемент в массив результата
    $result[] = [
        'url' => $file,
        'path' => $path . DS . $file,
        'name' => $name,
        'size' => round(filesize($absFile) / 1024, 2) . ' кб',
        'created_at' => date('H:i:s d.m.Y', filectime($absFile)),
        'changed_at' => date('H:i:s d.m.Y', filemtime($absFile)),
    ];
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <? if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', $errors) ?>
                </div>
            <? endif;

            //форма для редактирования файла / директории:
            if ($show_edit_form): ?>
                <div class="container">
                    <form action="" method="post">
                        <label for="file_content" class="col-form-label-sm">Содержимое
                            файла <?= $_GET['file'] ?>:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control row" id="file_content"
                                      name="file_content"><?= $file_content
                                ?></textarea>
                        </div>
                        <input type="text" name="dir" value="<?= $path ?>" hidden>
                        <input type="text" name="file" value="<?= $_GET['file'] ?>" hidden>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="reset" class="btn btn-primary">Не сохранять</button>
                        <a class="btn btn-primary" href="?dir=<?= $path ?>" title="Отменить и закрыть">Отменить и
                            закрыть</a>
                    </form>
                </div>
                <script>
                    document.getElementById('file_content').focus();
                </script>
            <? endif;

            //форма для переименования файла / директории:
            if ($show_rename_form): ?>
                <div class="container">
                    <form action="" method="get">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label-sm">Текущее имя файла /
                                директории:</label>
                            <div class="col-sm-6">
                                <p class="form-control-static-sm"><?= $_GET['old'] ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_name" class="col-sm-2 col-form-label">Новое имя файла /
                                директории:</label>
                            <div class="col-sm-6">
                                <input class="form-control form-control-sm" type="text" id="new_name"
                                       onfocus="this.select()" name="new" value="<?= $_GET['old'] ?>"
                                       placeholder="новое имя файла / директории" required>
                            </div>
                        </div>
                        <input type="text" id="old_name" name="old_name" value="<?= $old_name ?>" hidden>
                        <input type="text" name="dir" value="<?= $path ?>" hidden>
                        <button type="submit" class="btn btn-primary">Переименовать</button>
                    </form>
                </div>
                <script>
                    document.getElementById('new_name').focus();
                </script>
            <? endif; ?>

<!--            Обычный вывод списка файлов: -->
            <table class="table table-hover" width="100">
                <thead>
                <tr class="bg-warning">
                    <th>Действия</th>
                    <th>Имя файла</th>
                    <th>Размер файла</th>
                    <th>Дата создания</th>
                    <th>Дата изменения</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($result as $file):
                    ?>
                    <tr>
                        <td>
<!--                            Тут наши действия с объектом текущей строки:-->
                            <? if ($file['url'] != '..'): ?>
                                <span class="flex-row">
                                        <a href="?del=<?= $file['path'] ?>" title="Удалить выделенный файл/директорию">[Удалить]</a>
                                </span>
                                <span class="flex-row">
                                    <a href="?dir=<?= dirname($file['path']) ?>&old=<?= $file['url'] ?>"
                                       title="Переименовать текущую директорию / файл">[Переименовать]</a>
                                </span>
                            <? endif;
                            $file_path = $base . $file['path'];
                            if (is_file($file_path)) {
                                $file_type = mime_content_type($file_path);
                                if (strpos($file_type, "text/") !== false) { ?>
                                    <span class="flex-row">
                                    <a href="?file=<?= $file_path ?>&dir=<?= dirname($file['path']) ?>"
                                       title="Редактировать содержимое файла">[Редактировать]</a>
                                </span>
                                <? }
                            }
                            ?>
                        </td>
                        <td><?= $file['name'] ?></td>
                        <td><?= $file['size'] ?></td>
                        <td><?= $file['created_at'] ?></td>
                        <td><?= $file['changed_at'] ?></td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
