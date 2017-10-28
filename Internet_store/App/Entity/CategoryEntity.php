<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.10.2017
 * Time: 15:31
 */

namespace App\Entity;

class CategoryEntity extends Base
{
    /**
     * метод для получения имени таблицы, с которой работают остальные методы
     * @return string
     */
    public function getTableName(): string
    {
        return $GLOBALS['tablesMap']['category'];
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

    /**
     * Этот метод вызываем перед каждым обновлением/добавлением,
     * здесь проверяем каждый элемент массива на соответствие типу из массива
     * полученного в getMap, если тип не соответствует - выбрасываем исключение.
     *
     * @param array $data
     * @param string $tableName
     * @return bool
     * @throws \Exception
     */
    protected function checkFields(array $data, string $tableName = ''): bool
    {
        $checkSum = true;
        $fieldTypes = $this->getMap();
        foreach ($data as $key => $val) {
            if (!array_key_exists($key, $fieldTypes)) {
                throw new \Exception("Поле '$key' не найдено в таблице '" . $tableName . "'");
            } else if ($fieldTypes[$key] <> gettype($val)) {
                throw new \Exception("Тип данных в поле '$key' не соответствует типу данных в таблице '" .
                    $tableName . "'");
            }
        }
        return $checkSum;
    }
}
