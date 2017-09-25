<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 20.09.2017
 * Time: 20:22
 */

define('DS', DIRECTORY_SEPARATOR);

// Определим где мы будем хранить картинки
$galleryDir_local = 'gallery_files';
$galleryDir = __DIR__ . DS . $galleryDir_local;

// Если директория не создана - создаем
if (!is_dir($galleryDir)) {
    mkdir($galleryDir);
}

// Логика обработки запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['upload_file'];

    $errors = [];
    if (file_exists($file['tmp_name'])) {
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mime = mime_content_type($file['tmp_name']);

        $allow_extension = array(
            "bmp" => "image/bmp",
            "gif" => "image/gif",
            "ief" => "image/ief",
            "jpeg" => "image/jpeg",
            "jpg" => "image/jpeg",
            "jpe" => "image/jpeg",
            "png" => "image/png",
            "tif" => "image/tif",
            "tiff" => "image/tiff",
        );  //other mime-types here: http://www.phpclasses.org/browse/file/2743.html

        if ($mime !== $file['type']) {
            $errors[] = 'Ваш файл не прошел проверку';
        } else {
            // делаем проверку на mime-type == image/...
            if (strpos($mime, "image/") !== false) {
                foreach ($allow_extension as $key => $value) {
                    if (($value == $mime) && ($key == $extension)) {
                        // Если все ок - перемещаем загруженную картинку в свою директорию
                        move_uploaded_file($file['tmp_name'], $galleryDir . DS . $file['name']);
                    }
                }
            } else {
                $errors[] = "Загружать можно толко рисунки (.jpg, .gif, .png, .tiff и т.д.) !";
            }
        }
    } else {
        $errors[] = "Превышен максимальный размер загружаемого файла (" . ini_get('upload_max_filesize') . ")";
    }
}


// Получаем список файлов директории и очищаем от лишних элементов
$images = array_diff(scandir($galleryDir), ['.', '..']);

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
            <h1>Загрузите свои картинки</h1>
            <? if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', $errors) ?>
                </div>
            <? endif; ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="file" name="upload_file" required class="form-control">
                </div>
                <p class="form-text text-muted">Максимальный размер картинок для
                    загрузки: <?= ini_get('upload_max_filesize') ?></p>
                <button type="submit" class="btn btn-primary">
                    Отправить
                </button>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <? foreach ($images as $imgPath): ?>
                    <div class="col-md-6"
                         style="height: 250px; background: url('asset/get_img.php?name=<?= "/" . $galleryDir_local . "/" .
                         $imgPath ?>') no-repeat
                                 center/cover;">
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>