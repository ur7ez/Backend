<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 02.11.2017
 * Time: 14:38
 */

namespace App\Main;
class Config implements IConfig
{
    private static $paramArr = [
        'dbHost' => 'localhost',
        'dbUser' => 'goods',
        'dbPassword' => 'goods',
        'dbName' => 'goods',
        'rowsPerPageInCategory' => 5,
        'rowsPerPageInGoods' => 5,
        'tablesMap' => [
            'category' => 'category',
            'product' => 'product',
        ],
    ];

    /**
     * @param string $paramName
     * @return mixed
     */
    public static function get(string $paramName)
    {
        return self::$paramArr[$paramName];
    }
}

interface IConfig
{
    public static function get(string $paramName);
}
