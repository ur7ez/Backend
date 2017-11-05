<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.10.2017
 * Time: 15:31
 */

namespace App\Entity;

use App\DB\IConnection,
    App\Main\IConfig;

class CategoryEntity extends Base
{
    private $config;

    public function __construct(IConnection $conn, IConfig $cfg)
    {
        parent::__construct($conn);
        $this->config = $cfg;
    }

    /**
     * метод для получения имени таблицы, с которой работают остальные методы
     * @return string
     */
    public function getTableName(): string
    {
        return $this->config::get('tablesMap')['category'];
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
            'description' => 'string',  //'text'
        ];
        return $fieldsTypes;
    }
}
