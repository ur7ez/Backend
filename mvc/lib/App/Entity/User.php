<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 19.11.2017
 * Time: 1:32
 */

namespace App\Entity;

use App\Core\Config;

class User extends Base
{
    public function getTableName()
    {
        return 'users';
    }

    public function checkFields($data)
    {
        if (!isset($data['login']) || !isset($data['email']) || !isset($data['password'])
            || !strlen($data['login']) || !strlen($data['email']) || !strlen($data['password'])) {
            throw new \Exception('Registration data fields can\'t be empty');
        }
    }

    public function register($data)
    {
        $data['role'] = 'user';
        $data['password'] = md5(Config::get('sault') . $data['password']);
        if ($this->getByLogin($data['login'])) {
            return false;
        } else {
            return $this->save($data);
        }
    }

    public function getByLogin($login)
    {
        $sql = 'SELECT * FROM ' . $this->getTableName()
            . ' WHERE login = ' . $this->conn->escape($login) . ' LIMIT 1';
        $result = $this->conn->query($sql);

        return isset($result[0]) ? $result[0] : null;
    }
}