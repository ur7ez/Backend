<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 18.11.2017
 * Time: 23:17
 */

namespace App\Core;

class Session
{
    protected static $flash_message;

    public static function setFlash($message)
    {
        static::$flash_message = $message;
    }

    public static function hasFlash()
    {
        return !is_null(static::$flash_message);
    }

    public static function flash()
    {
        echo static::$flash_message;
        static::$flash_message = null;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    public static function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        session_destroy();
    }
}