<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 18.09.2017
 * Time: 18:55
 */
$filename = __DIR__ . '/data/data.txt';
$censoredfilename = __DIR__ . '/data/censored.txt';

// get array of all existing comments
$comments = unserialize(file_get_contents($filename));
//censored words file:
$censored = explode(PHP_EOL, file_get_contents($censoredfilename));
// Строка с сообщением об ошибках
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //logic comes here
    $author = trim(htmlspecialchars($_POST['author']));
    $comment = trim(htmlspecialchars($_POST['comment']));
    $email = trim(htmlspecialchars($_POST['e-mail']));

    if (array_search($email, array_column($comments, 'email')) !== false) {
        $errors[] = "Человек с таким e-mail уже заполнял форму!";
    } elseif (strlen(trim($author)) && trim(strlen($comment)) && !($errors)) {
        $comments[] = [
            'date' => date('H:i:s d.m.Y'),
            'timestamp' => time(),
            'author' => $author,
            'comment' => $comment,
            'email' => $email,
        ];
        //rewrite data.txt with all previous + newly added comments
        file_put_contents($filename, serialize($comments));
    } else {
        $errors[] = "Форма заполнена некорректно: пустые поля недопустимы!";
    }
}

if ($comments) {
    usort($comments, function ($a, $b) {
        return (isset($a['timestamp']) && $a['timestamp'] > $b['timestamp']) ? -1 : 1;
    });

// Постраничная навигация
    $commentsPerPage = 5;
    $currentPage = 1;

    if (isset($_GET['p']) && $_GET['p'] > 1) {
        $currentPage = (int)$_GET['p'];
    }
// Вырезать нужные комментарии из $comments
    $comments_trunc = array_slice($comments, $commentsPerPage * ($currentPage - 1), $commentsPerPage);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>a small site</title>
    <!-- Bootstrap (https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css)-->
    <link rel="stylesheet" href="css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Поделитесь вашим мнением:</h2>
            <? if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', $errors) ?>
                </div>
            <? endif; ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="author">Ваше имя: </label>
                    <input type="text" class="form-control" id="author" name="author" placeholder="имя тут"
                           tabindex="1" required>
                </div>
                <div class="form-group">
                    <label for="e-mail">Ваш e-mail: </label>
                    <input type="email" class="form-control" id="e-mail" name="e-mail" placeholder="Ваш e-mail тут"
                           tabindex="2" required>
                </div>
                <div class="form-group">
                    <label for="comment">Ваше мнение: </label>
                    <textarea class="form-control" name="comment" id="comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>

        <div class="col-md-6 col-md-offset-3">
            <?php
            if ($comments):
                // вывод комментариев
                foreach ($comments_trunc as $comment):

                    //убираем нежелательные слова:
                    foreach (['author', 'comment'] as $key):
                        $comment[$key] = str_ireplace($censored, '[censored]', $comment[$key]);
                    endforeach;
                    ?>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <?= $comment['author'] ?>
                            <span><?= array_key_exists('email', $comment) ? "[" . $comment['email'] . "]" : "" ?></span>
                            <span> at <?= $comment['date'] ?> wrote:</span>
                        </div>
                        <div class="panel-body">
                            <?= $comment['comment'] ?>
                        </div>
                    </div>
                    <!--                <hr>-->

                    <?
                endforeach;
                // Вывод ссылок постраничной навигации
                for ($j = 1; $j <= (int)((count($comments) % $commentsPerPage) ? 1 : 0) + intval(count($comments) / $commentsPerPage); $j++):
                    ?>
                    <div class="pagination">
                        <a href="?p=<?= $j ?>"><?= $j ?></a>
                    </div>
                <? endfor;
            endif; ?>
        </div>
    </div>
</div>
</body>
</html>
