<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 18.09.2017
 * Time: 18:55
 */
$host = 'localhost';
$db = 'feedback';
$user = 'root';
$pass = '';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$pdo->query('SET NAMES utf8;');
$pdo->query('SET CHARSET utf8;');

$filename = __DIR__ . '/data/data.txt';
$censoredFilename = __DIR__ . '/data/censored.txt';

//  censored words file:
$censored = explode(
    PHP_EOL,
    file_get_contents($censoredFilename)
);

// Строка с сообщением об ошибках
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // logic comes here
    $author = trim(htmlspecialchars($_POST['author']));
    $comment = trim(htmlspecialchars($_POST['comment']));
    $email = trim(htmlspecialchars($_POST['e-mail']));

    if (strlen($author) && strlen($comment)) {

        $statement = $pdo->prepare('SELECT id FROM author WHERE email = :email');
        $statement->execute([
            'email' => $email,
        ]);

        $authorId = $statement->fetch(PDO::FETCH_COLUMN);

        try {
            $pdo->beginTransaction();

            if (empty($authorId)) {
                $statement = $pdo->query(
                    "INSERT INTO author (email, author) 
                      VALUES (" . $pdo->quote($email) . ", " . $pdo->quote($author) . ")"
                );
                $authorId = $pdo->lastInsertId();
            }
            $statement = $pdo->prepare('INSERT INTO comment (author_id, comment) VALUES (?, ?)');
            $statement->bindValue(1, $authorId);
            $statement->bindParam(2, $willBeComment);
            $willBeComment = $comment;

            $statement->execute();
            $pdo->commit();

        } catch (PDOException $e) {
            $pdo->rollBack();
            $errors[] = $e->getMessage();
        }

    } else {
        $errors[] = "Форма заполнена некорректно: пустые поля недопустимы!";
    }
}

class Comment
{
    private $id;

    private $author;
    private $author_id;
    private $comment;
    private $email;
    private $timestamp;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}

/*
    usort($comments, function ($a, $b) {
        return (isset($a['timestamp']) && $a['timestamp'] > $b['timestamp']) ? -1 : 1;
    });
*/

$stmt = $pdo->query(
    "SELECT id, comment FROM feedback.comment;",
    PDO::FETCH_KEY_PAIR
);
$commentsCNT = count($stmt->fetchAll());

// Постраничная навигация
$commentsPerPage = 5;
$currentPage = 1;

if (isset($_GET['p']) && $_GET['p'] > 1) {
    $currentPage = (int)$_GET['p'];
    if ($commentsCNT < (($currentPage - 1) * $commentsPerPage + 1)) {
        $currentPage = 1;
    }
}

// Вырезать нужные комментарии из $comments
$comments = $pdo->query(
    'SELECT comment.*, author.author, author.email  
      FROM comment LEFT JOIN author on author.id = comment.author_id
      ORDER BY comment.timestamp DESC LIMIT ' . $commentsPerPage * ($currentPage - 1) . ', ' . $commentsPerPage . ';',
    PDO::FETCH_OBJ);

/*
$result = $pdo->query('SELECT comment.id, comment.comment FROM comment', PDO::FETCH_KEY_PAIR);
echo '<pre>';
print_r($result->fetchAll());
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Comments</title>
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
                    <input type="text" class="form-control"
                           id="author" name="author"
                           placeholder="имя тут" tabindex="1" autofocus required>
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
            // вывод комментариев
            while ($comment = $comments->fetchObject(Comment::class)):
            /* @var Comment $comment */

            ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <?= $comment->getAuthor() ?>
                    <span>[<?= $comment->getEmail() ?>]</span>
                    <span> at <?= $comment->getTimestamp() ?> wrote:</span>
                </div>
                <div class="panel-body">
                    <?= str_ireplace(
                        $censored,
                        '[censored]',
                        $comment->getComment()
                    ); ?>
                </div>
            </div>
            <hr>
            <div class="pagination">
                <?php
                endwhile;
                // Вывод ссылок постраничной навигации
                for ($j = 1; $j <= ceil($commentsCNT / $commentsPerPage); $j++):
                    if ($currentPage !== $j): ?>
                        <a href="?p=<?= $j ?>"><?= $j ?></a>
                    <? else: ?>
                        <?= $j ?>
                    <? endif; ?>
                <? endfor; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>