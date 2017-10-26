<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 16.10.2017
 * Time: 20:02
 */

$dbHost = 'localhost';
$dbUser = 'goods';
$dbPassword = 'goods';
$dbName = 'goods';

$connection = mysqli_connect(
    $dbHost,
    $dbUser,
    $dbPassword,
    $dbName
);
$connection->query('SET NAMES utf8;');
$connection->query('SET CHARSET utf8;');

$tablesMap = [
    'category' => 'category',
    'product' => 'product',
];

/** Get entity */

/**
 * @param null $id
 * @param null|integer $rows_cnt
 * @param integer $offset
 * @return bool|mysqli_result
 */
function categoryList($id = null, $rows_cnt = null, $offset = 0)
{
    return getList($GLOBALS['tablesMap']['category'], $id, $rows_cnt, $offset);
}

/**
 * @param null $id
 * @param null|integer $rows_cnt
 * @param integer $offset
 * @return bool|mysqli_result
 */
function productList($id = null, $rows_cnt = null, $offset = 0)
{
    return getList($GLOBALS['tablesMap']['product'], $id, $rows_cnt, $offset);
}

/**
 * @param $tableName
 * @param null $id
 * @param null|integer $rows_cnt
 * @param integer $offset
 * @return bool|mysqli_result
 */
function getList($tableName, $id = null, $rows_cnt = null, $offset = 0)
{
    global $connection;

    $where = '';
    if ($id > 0) {
        $where = ' WHERE ID = ' . $id;
    }
    $lim = '';
    if ($rows_cnt > 0) {
        $lim = "LIMIT $offset, $rows_cnt";
    }
    return mysqli_query(
        $connection,
        "SELECT * FROM $tableName $where $lim;"
    );
}

/**
 * @return integer
 */
function categoryCount()
{
    return countList($GLOBALS['tablesMap']['category']);
}

/**
 * @return integer
 */
function productCount()
{
    return countList($GLOBALS['tablesMap']['product']);
}

/**
 * @param $tableName
 * @return integer
 */
function countList($tableName)
{
    global $connection;

    $stmt = mysqli_fetch_all(mysqli_query(
        $connection,
        "SELECT count(id) CNT FROM $tableName;"
    ));
        return (int) $stmt[0][0];
}

/** Create entity */

/**
 * @param $fields
 * @return bool|mysqli_result
 */
function createCategory($fields)
{
    return createEntity(
        $GLOBALS['tablesMap']['category'],
        $fields
    );
}

/**
 * @param $fields
 * @return bool|mysqli_result
 */
function createProduct($fields)
{
    return createEntity(
        $GLOBALS['tablesMap']['product'],
        $fields
    );
}

/**
 * @param $tableName
 * @param $data
 * @return bool|mysqli_result
 */
function createEntity($tableName, $data)
{
    global $connection;

    foreach ($data as &$val) {
        $val = mysqli_escape_string($connection, $val);
    }

    $cols = implode(',', array_keys($data));
    $values = "'" . implode("','", $data) . "'";

    return mysqli_query(
        $connection,
        "INSERT INTO $tableName ($cols) VALUES ($values);"
    );
}

/** Update entity */

/**
 * @param $id
 * @param $data
 * @return bool|mysqli_result
 */
function updateCategory($id, $data)
{
    return updateEntity(
        $GLOBALS['tablesMap']['category'],
        $id,
        $data
    );
}

/**
 * @param $id
 * @param $data
 * @return bool|mysqli_result
 */
function updateProduct($id, $data)
{
    return updateEntity(
        $GLOBALS['tablesMap']['product'],
        $id,
        $data
    );
}

/**
 * @param $tableName
 * @param $id
 * @param $data
 * @return bool|mysqli_result
 */
function updateEntity($tableName, $id, $data)
{
    global $connection;

    $values = [];

    foreach ($data as $key => $val) {
        $val = mysqli_escape_string($connection, $val);
        $values[] = "$key = '$val'";
    }
    $values = implode(',', $values);

    return mysqli_query(
        $connection,
        "UPDATE $tableName SET $values WHERE id = $id;"
    );
}

/**
 * @param $id
 * @return bool|mysqli_result
 */
function deleteCategory($id)
{
    return deleteEntity(
        $GLOBALS['tablesMap']['category'],
        $id
    );
}

/**
 * @param $id
 * @return bool|mysqli_result
 */
function deleteProduct($id)
{
    return deleteEntity(
        $GLOBALS['tablesMap']['product'],
        $id
    );
}

/**
 * @param $tableName
 * @param $id
 * @return bool|mysqli_result
 */
function deleteEntity($tableName, $id)
{
    global $connection;

    return mysqli_query(
        $connection,
        "DELETE FROM $tableName WHERE id = $id;"
    );
}