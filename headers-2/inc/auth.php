<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 30.09.2017
 * Time: 1:24
 */

/**
 * Тут должна быть проверка логина и пароля
 * если они правильные, то нужно поставить $_SESSION['auth'] = true;
 * затем обновить страницу.
 */
//$_SESSION['auth'] = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $chk_login = array_search($_POST['login'], array_column($config['users'], 0));
    if ($chk_login === false) {
        $errors[] = "Пользователь '" . $_POST['login'] . "' не зарегистрирован! Пройдите регистрацию или повторите вход.";
    } else {
//пользователь существует, проверяем проавильность пароля пользователя:
        if ($config['users'][$chk_login][1] !== sha1($salt . $_POST['password'])) {
            $errors[] = "Неверный пароль! Повторите попытку";
        } else {
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $_POST['login'];
            header("location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
        }
    }
}
?>
<div class="container">
    <main class="row">
        <div class="col-md-6 offset-md-3" style="text-align: center">
            <? if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', $errors) ?>
                </div>
            <? endif; ?>
            <h1>Вход</h1>
            <form action="" method="post">
                <div class="form-group">
                    <input name="login" type="text"
                           class="form-control"
                           placeholder="Логин" required>
                </div>
                <div class="form-group">
                    <input name="password" type="password"
                           class="form-control"
                           placeholder="Пароль" required>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
            <!--            ссылка на форму регистрации -->
            <h2>
                <a href="index.php?page=register" title="Форма регистрации нового пользователя">Регистрация</a>
            </h2>
        </div>
    </main>
</div>