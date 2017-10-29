<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.10.2017
 * Time: 15:31
 */

namespace App\Entity;

class ProductEntity extends Base
{
    /**
     * метод для получения имени таблицы, с которой работают остальные методы
     * @return string
     */
    public function getTableName(): string
    {
        return $GLOBALS['tablesMap']['product'];
    }

    /**
     * Метод должен вовращать поля текущей таблицы (кроме id)
     * в формате:
     * [
     *      'fieldName' => 'fieldType',
     *      'fieldName2' => 'fieldType',
     *      ...
     * ]
     *
     * @return array
     */
    public function getMap(): array
    {
        /*
         * global $connection;
        $tableName = $this->getTableName();
        return mysqli_fetch_all(mysqli_query(
            $connection,
            "SELECT COLUMN_NAME, DATA_TYPE
                    FROM information_schema.COLUMNS
                    WHERE TABLE_SCHEMA = 'goods' AND TABLE_NAME = '" . $tableName . "' AND COLUMN_NAME <> 'id';"
        ));
        */

        $fieldsTypes = [
            'title' => 'string', //'varchar' in MySQL
            'price' => 'double', //'float'
            'description' => 'string', //'text'
            'category_id' => 'integer', //'int'
        ];
        return $fieldsTypes;
    }
}
