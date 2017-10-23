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
    if (is_null($_POST['category'])) {
        $errors[] = 'Категория товара не может быть пустой. Выберите категорию товара';
    }
    if ((float)$_POST['price'] == 0) {
        $errors[] = 'Цена товара не указана, равна 0 или не является числом.';
    }
    if (!$errors) {
        $category_id = $_POST['category'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $data = [];
        if (strlen($title)) {
            $data['title'] = $title;
        }
        $data['price'] = (float)$price;
        $data['description'] = $description;
        $data['category_id'] = (int)$category_id;

        if (!empty($data)) {
            if ($id > 0) {
                $result = updateProduct($id, $data);
            } else {
                $result = createProduct($data);
            }
        }
    }
}

$id = $_GET['id'];

if (isset($id) && isset($_GET['delete'])) {
    deleteProduct($id);
    $id = null;
}

$productCNT = (int)productCount()[0][0];
// Постраничная навигация
$rowsPerPage = 5;
$currentPage = 1;

if (isset($_GET['p']) && $_GET['p'] > 1) {
    $currentPage = (int)$_GET['p'];
    if ($productCNT < (($currentPage - 1) * $rowsPerPage + 1)) {
        $currentPage = 1;
    }
}
// Вырезать нужные строки
$productResult = productList(null, $rowsPerPage, $rowsPerPage * ($currentPage - 1));

?>
<div class="container">
    <a href="?page=product&p=<?= $currentPage ?>&id=0">Добавить товар</a>
    <br><br>
    <?php if (isset($id)) {
        $title = '';
        $price = null;
        $category_id = 0;
        $categoryResult = categoryList();
        $description = '';
        if ($id > 0) {
            $product = mysqli_fetch_assoc(productList($id));
            $title = htmlspecialchars($product['title'], ENT_QUOTES | ENT_HTML401);
            $description = htmlspecialchars($product['description']);
            $price = $product['price'];
            $category_id = $product['category_id'];
        }
        ?>
        <? if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?= implode('<br>', $errors) ?>
            </div>
        <? endif; ?>
        <br>
        <form action="?page=product<?= "&p=" . $currentPage ?>" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input autofocus required placeholder="Название товара" name="title" title="Название товара" value='<?= $title ?>'>
        <input type="number" step="0.01" value="<?= $price ?>"
               title="Цена товара" placeholder="Цена товара" name="price">
        <label for="select1">Категория товара: </label>
        <select name="category" id="select1" title="Категория товара" required>
            <option disabled selected>Выберите категорию ...</option>
            <?php
            while ($category = mysqli_fetch_assoc($categoryResult)) {
                ?>
                <option
                    <?= ($category['id'] === $category_id) ? "selected" : "" ?>
                        value="<?= $category['id'] ?>"><?= htmlspecialchars(
                        $category['title'],
                        ENT_QUOTES | ENT_HTML401
                    ) ?></option>
                <?
            }
            ?>
        </select>
        <p>
                <textarea maxlength="65530" name="description" id="" cols="80" rows="8" title="Описание товара"
                          placeholder="Детальное описание"><?= $description ?></textarea>
        </p>
        <input type="submit" name="save" value="Сохранить">
        <input type="reset" name="cancel" value="Отмена">
        </form>
        <br>
        <br>


    <? } ?>
</div>
<div>
    <table border="1" bordercolor="lightgrey" rules="all" style="max-width: 80%;">
        <caption><i>Список товаров магазина (прайс)</i></caption>
        <thead>
        <tr align="center">
            <td>Действия</td>
            <td style="min-width: 30px;">ID</td>
            <td style="width: 15%;">Наименование</td>
            <td style="width: 10%;">Цена по прайсу</td>
            <td style="width: 15%;">Категория</td>
            <td>Детальное описание</td>
        </tr>
        </thead>
        <?php
        while ($product = mysqli_fetch_assoc($productResult)) {
            ?>
            <tr>
                <td align="center">
                    <a href="?page=product&p=<?= $currentPage ?>&id=<?= $product['id'] ?>&delete"
                       title="Удалить товар"><input type="button" value="x"></a>
                    <a href="?page=product&p=<?= $currentPage ?>&id=<?= $product['id'] ?>" title="Редактировать товар">
                        <input type="button" value="...">
                    </a>
                </td>
                <td>
                    <?= $product['id'] ?>.
                </td>
                <td>
                    <?= htmlspecialchars($product['title'], ENT_QUOTES | ENT_HTML401) ?>
                </td>
                <td>
                    <?= $product['price'] ?>
                </td>
                <td><?= htmlspecialchars(
                        mysqli_fetch_assoc(
                            categoryList($product['category_id']
                            ))['title']
                        , ENT_QUOTES | ENT_HTML401) ?></td>
                <td>
                    <?= htmlspecialchars($product['description'], ENT_QUOTES | ENT_HTML401) ?>
                </td>
            </tr>
            <?
        }
        ?>
    </table>
</div>
<div>
    <!--    Вывод ссылок постраничной навигации-->
    <p>Перейти на страницу:
        <?
        for ($j = 1; $j <= (int)(($productCNT % $rowsPerPage) ? 1 : 0) + intval($productCNT / $rowsPerPage); $j++):
            ?>
            <span class="pagination">
        <? if ($currentPage !== $j): ?>
            <a href="?page=product&p=<?= $j ?>"><?= $j ?></a>
        <? else: ?>
            <?= $j ?>
        <? endif; ?>
        </span>
        <? endfor;
        ?>
    </p>
</div>