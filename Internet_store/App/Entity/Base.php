<?php
/**
 * базовый абстрактный класс для CRUD операций над сущностями в таблице
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.10.2017
 * Time: 1:31
 */

namespace App\Entity;

use App\DB\IConnection;

/**
 * Class Base
 * @package App\Entity
 */
abstract class Base
{
    protected $connection;

    public function __construct(IConnection $conn)
    {
        $this->connection = $conn;
    }

    /**
     * @return string
     */
    abstract public function getTableName(): string;

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
    abstract public function getMap(): array;

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
        if ($tableName == '') {
            $tableName = $this->getTableName();
        }
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

    /**
     * В этом методе получаем список элементов таблицы
     * полученной из метода getTableName
     *
     * @param int|null $id
     * @param null|integer $rows_cnt
     * @param integer $offset
     * @return bool|\mysqli_result
     */
    public function get(int $id = null, $rows_cnt = null, $offset = 0)
    {
        $tableName = $this->getTableName();
        $where = '';
        if ($id > 0) {
            $where = ' WHERE ID = ' . $id;
        }
        $lim = '';
        if ($rows_cnt > 0) {
            $lim = "LIMIT $offset, $rows_cnt";
        }
        return $this->connection->query(
            "SELECT * FROM $tableName $where $lim;"
        );
    }

    /**
     * Получает количество записей в таблице
     * полученной из метода getTableName
     * @return int
     */
    public function count()
    {
        $tableName = $this->getTableName();
        $stmt = mysqli_fetch_all($this->connection->query(
            "SELECT count(id) CNT FROM $tableName;"
        ));
        return (int)$stmt[0][0];
    }

    /**
     * В этом методе создаем новую запись в таблице getTableName.
     * Перед созданием проверяем корректность данных вызовом метода checkFields.
     *
     * @param array $data
     * @return bool|\mysqli_result
     */
    public function create(array $data)
    {
        global $errors;
        $tableName = $this->getTableName();
        try {
            $this->checkFields($data, $tableName);
            foreach ($data as &$val) {
                $val = mysqli_escape_string($this->connection->get(), $val);
            }

            $cols = implode(',', array_keys($data));
            $values = "'" . implode("','", $data) . "'";
            return $this->connection->query(
                "INSERT INTO $tableName ($cols) VALUES ($values);"
            );
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
            return false;
        }
    }

    /**
     * В этом методе обновляем запись в таблице getTableName.
     * Перед обновлением проверяем корректность данных вызовом метода checkFields.
     *
     * @param int $id
     * @param array $data
     * @return bool|\mysqli_result
     */
    public function update(int $id, array $data)
    {
        global $errors;
        $tableName = $this->getTableName();
        $values = [];

        try {
            $this->checkFields($data, $tableName);
            foreach ($data as $key => $val) {
                $val = mysqli_escape_string($this->connection->get(), $val);
                $values[] = "$key = '$val'";
            }
            $values = implode(',', $values);
            return $this->connection->query(
                "UPDATE $tableName SET $values WHERE id = $id;"
            );
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
            return false;
        }
    }

    /**
     * В этом методе удаляем запись в таблице getTableName по id.
     *
     * @param int $id
     * @return bool|\mysqli_result
     */
    public function delete(int $id)
    {
        $tableName = $this->getTableName();

        return $this->connection->query(
            "DELETE FROM $tableName WHERE id = $id;"
        );

    }
}