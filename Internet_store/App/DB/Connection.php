<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 02.11.2017
 * Time: 14:47
 */

namespace App\DB;

use App\Main\Config;

abstract class Singleton
{
    protected static $instance = null;

    final public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    abstract protected function __construct();

    final private function __clone()
    {
    }

    final private function __sleep()
    {
    }

    final private function __wakeup()
    {
    }
}

class Connection extends Singleton implements IConnection
{
    private static $connection;

    protected function __construct()
    {
        $dbHost = Config::get('dbHost');
        $dbName = Config::get('dbName');
        $dbUser = Config::get('dbUser');
        $dbPassword = Config::get('dbPassword');
        $conn = mysqli_connect(
            $dbHost,
            $dbUser,
            $dbPassword,
            $dbName
        );
        $conn->query('SET NAMES utf8;');
        $conn->query('SET CHARSET utf8;');
        static::$connection = $conn;
    }

    /**
     * @return \mysqli
     */
    public function get()
    {
        return static::$connection;
    }

    /**
     * @param string $queryStr
     * @return bool|\mysqli_result
     */
    public function query(string $queryStr)
    {
        return mysqli_query(static::$connection, $queryStr);
    }
}

interface IConnection
{
    /**
     * @param string $queryStr
     * @return bool|\mysqli_result
     */
    public function query(string $queryStr);

    /**
     * @return \mysqli
     */
    public function get();
}