<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 02.10.2017
 * Time: 15:47
 */
//1. Создать отдельную страницу (в директории `inc`) для вывода формы регистрации. Добавить ссылку на эту страницу под форму входа. В форме три поля - Логин, Пароль, Подтверждение пароля. Убедиться, что неавторизованный пользователь может зарегистрироваться. Список пользователей хранить в отдельом файле в директории `config` (или создать отдельную) в сериализованном виде. Пароль в открытом виде храниться не должен, храним только контрольную сумму (`sha1` или `md5`) с добавлением примеси (`$salt`). В массив конфигурации в `config/global.php` в ключ `users` записывать массив, полученный из этого файла.

$errors = [];
$susses = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = $config['users'];
    if (in_array($_POST['login'], array_column($users, 0))) {
        $errors[] = "Пользователь '" . $_POST['login'] . "' уже зарегистрирован! Повторите попытку.";
    } else {
        if ($_POST['password'] === $_POST['password_cfm']) {
            $users[] = [$_POST['login'], sha1($salt . $_POST['password'])];
            if (file_put_contents($users_file, serialize($users)) === false) {
                $errors[] = "Ошибка записи в файл";
            } else {
                $config['users'] = $users;
                header("location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . DS . "?page=auth");
            }

        } else {
            $errors[] = 'Пароли не совпадают! Повторите попытку ...';
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
            <h1>Регистрация</h1>
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
                <div class="form-group">
                    <input name="password_cfm" type="password"
                           class="form-control"
                           placeholder="Подтверждение пароля" required>
                </div>
                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            </form>
        </div>
    </main>
</div>
