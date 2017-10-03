<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.09.2017
 * Time: 19:50
 */
?>
<div class="container mb-5">
    <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
        <a class="navbar-brand" href="index.php"><?= $config['company'] ?></a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <?php foreach ($config['menu'] as $item): ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?page=<?= $item['id'] ?>">
                            <?= $item['title'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item active">
                    <span class="nav-link">{{basket}}</span>
                </li>
            </ul>
        </div>
        <? if (isset($_SESSION['auth'])) { ?>
            <span style="width: 170px;">Привет {{login}}</span>
            <form action="">
                <input type="submit" name="logout" value="Logout" style="float: right;">
            </form>
        <? } ?>
    </nav>
</div>