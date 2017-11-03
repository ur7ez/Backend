<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 03.11.2017
 * Time: 15:04
 */
namespace App\DB;
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
