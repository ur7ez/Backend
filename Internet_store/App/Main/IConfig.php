<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 03.11.2017
 * Time: 15:07
 */
namespace App\Main;
interface IConfig
{
    public static function get(string $paramName);
}
