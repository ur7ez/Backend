<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 16.10.2017
 * Time: 19:59
 */
$errors = [];
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $data = [];
    if (strlen($title)) {
        $data['title'] = $title;
    }
    if (!empty($data)) {
        if ($id > 0) {
            $result = updateCategory($id, $data);
        } else {
            $result = createCategory($data);
        }
    }
}

$id = $_GET['id'];

if (isset($id) && isset($_GET['delete'])) {
    deleteCategory($id);
    $id = null;
}

$categoryCNT = (int)categoryCount()[0][0];
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
$categoryResult = categoryList(null, $rowsPerPage, $rowsPerPage * ($currentPage - 1));

?>
<div class="container">
    <a href="?page=category&p=<?= $currentPage ?>&id=0">Добавить категорию</a>
    <?php if (isset($id)) {
        $title = '';
        if ($id > 0) {
            $category = mysqli_fetch_assoc(categoryList($id));
            $title = $category['title'];
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
                   title="Удалить категорию <?= $category['title'] ?>"><input type="button" value="x"></a>
                <a href="?page=category&p=<?= $currentPage ?>&id=<?= $category['id'] ?>">
                    <?= $category['id'] ?>: <?= htmlspecialchars($category['title'], ENT_QUOTES | ENT_HTML401) ?>
                </a>
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
        for ($j = 1; $j <= (int)(($categoryCNT % $rowsPerPage) ? 1 : 0) + intval($categoryCNT / $rowsPerPage); $j++):
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