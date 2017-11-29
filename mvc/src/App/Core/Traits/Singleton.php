<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 20.11.2017
 * Time: 19:12
 */

namespace App\Core\Traits;

trait Singleton
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
