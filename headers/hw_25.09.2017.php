<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 26.09.2017
 * Time: 15:43
 */

//1. Создать страницу которая будет иметь форму с полем для загрузки файла. При отправке формы должно появиться диалоговое окно для скачивания этого файла.

//2. При каждом посещении страницы отправляем клиенту cookie с именем `visits_count`, значение по-умолчанию - `1`. C каждым открытием страницы значение cookie должно увеличиваться на `1`. Когда значение cookie превысит `5` - нужно удалить куку. (На следующем за удалением открытием страницы - снова отправляем со значением по-умолчанию и идем по кругу)

define('DS', DIRECTORY_SEPARATOR);
include 'core.php';

if (isset($_COOKIE['visits_count'])) {
    if ($_COOKIE['visits_count'] >= 5) {
        setcookie('visits_count', '', 1, '/', $_SERVER['SERVER_NAME'], false, true);
    } else {
        setcookie(
            'visits_count', $_COOKIE['visits_count'] + 1,
            time() + 60 * 60 * 24,
            '/',
            $_SERVER['SERVER_NAME'],
            false,
            true
        );
    }
} else {
    setcookie(
        'visits_count', 1,
        time() + 60 * 60 * 24,
        '/',
        $_SERVER['SERVER_NAME'],
        false,
        true
    );
}

// Определим где мы будем хранить картинки
$file_Dir_local = 'files';
$galleryDir = __DIR__ . DS . $file_Dir_local;
// Если директория не создана - создаем
if (!is_dir($galleryDir)) mkdir($galleryDir);

// Логика обработки запроса на отправку / получение
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['upload_file'];

    $errors = [];
    if (check_uploaded_file($file, $errors, 'application/')) {
        //если проверка файла успешна - перемещаем загруженный файл в директорию
        move_uploaded_file($file['tmp_name'], $galleryDir . DS . $file['name']);
        //и тут же отдаем его клиенту:
        header('Content-Disposition: attachment; filename=' . $file['name']);
        readfile($galleryDir . DS . $file['name']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <title>Upload to my Gallery</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Загрузите файл:</h1>
            <? if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', $errors) ?>
                </div>
            <? endif; ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="file" name="upload_file" required class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">
                    Отправить
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>