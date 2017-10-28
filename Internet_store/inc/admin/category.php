<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 16.10.2017
 * Time: 19:59
 */

use App\Entity\CategoryEntity;

$errors = [];
$catObj = new CategoryEntity();

if (isset($_POST['save'])) {
    $id = $_POST['id'];
    if (empty($_POST['title']) || trim($_POST['title']) == '') {
        $errors[] = 'Категория товара не может быть пустой. Укажите категорию товара';
    }
    if (!$errors) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);

        $data = [];
        if (strlen($title)) {
            $data['title'] = $title;
        }
        $data['description'] = $description;
        if (!empty($data)) {
            if ($id > 0) {
                $result = $catObj->update($id, $data);
            } else {
                $result = $catObj->create($data);
            }
        }
    }
}

$id = $_GET['id'];

if (isset($id) && isset($_GET['delete'])) {
    $catObj->delete($id);
    $id = null;
}

$categoryCNT = $catObj->count();
// Постраничная навигация
$rowsPerPage = 5;
$currentPage = 1;

if (isset($_GET['p']) && $_GET['p'] > 1) {
    $currentPage = (int)$_GET['p'];
    if ($categoryCNT < (($currentPage - 1) * $rowsPerPage + 1)) {
        $currentPage = 1;
    }
}
// Вырезать нужные строки
$categoryResult = $catObj->get(null, $rowsPerPage, $rowsPerPage * ($currentPage - 1));

?>
<div class="container">
    <a href="?page=category&p=<?= $currentPage ?>&id=0">Добавить категорию</a>
    <?php if (isset($id)) {
        $title = '';
        $description = '';
        if ($id > 0) {
            $category = mysqli_fetch_assoc($catObj->get($id));
            $title = $category['title'];
            $description = htmlspecialchars($category['description']);
        }
        ?>
        <? if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?= implode('<br>', $errors) ?>
            </div>
        <? endif; ?>
        <form action="?page=category&p=<?= $currentPage ?>" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="text" value="<?= $title ?>"
                   placeholder="Название категории" name="title" required autofocus>
            <textarea maxlength="65530" name="description" id="" cols="50" rows="4" title="Описание категории"
                      placeholder="Детальное описание категории товара"><?= $description ?></textarea>
            <input type="submit" name="save" value="Сохранить">
        </form>
    <? } ?>
</div>
<div class="container">
    <ul>
        <?php
        while ($category = mysqli_fetch_assoc($categoryResult)) {
            ?>
            <li>
                <a href="?page=category&p=<?= $currentPage ?>&id=<?= $category['id'] ?>&delete"
                   title="Удалить категорию <?= $category['title'] ?>">
                    <button>x</button>
                </a>
                <a href="?page=category&p=<?= $currentPage ?>&id=<?= $category['id'] ?>"
                   title="<?= htmlspecialchars($category['description'], ENT_QUOTES | ENT_HTML401) ?>">
                    <?= $category['id'] ?>: <?= htmlspecialchars($category['title'], ENT_QUOTES | ENT_HTML401) ?>
                </a>
                <!--                <span title="детальное описание категории">-->
                <?//= htmlspecialchars($category['description'], ENT_QUOTES | ENT_HTML401) ?><!--</span>-->
            </li>
            <?
        }
        ?>
    </ul>
</div>
<div>
    <!--    Вывод ссылок постраничной навигации-->
    <p>Перейти на страницу:
        <?
        for ($j = 1; $j <= ceil($categoryCNT / $rowsPerPage); $j++):
            ?>
            <span class="pagination">
        <? if ($currentPage !== $j): ?>
            <a href="?page=category&p=<?= $j ?>"><?= $j ?></a>
        <? else: ?>
            <?= $j ?>
        <? endif; ?>
        </span>
        <? endfor;
        ?>
    </p>
</div>