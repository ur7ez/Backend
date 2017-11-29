<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 18.11.2017
 * Time: 23:17
 */

namespace App\Core;

use App\Core\Traits\Singleton;

class Session
{
    use Singleton;

    protected function __construct()
    {
        session_start();
    }

    /**
     * @param $message
     * @return void
     */
    public static function setFlash($message)
    {
        if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][] = $message;
    }

    /**
     * @return bool
     */
    public static function hasFlash()
    {
        return !empty($_SESSION['flash']);
    }

    /**
     * @return array
     */
    public static function flash()
    {
        $data = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
        $_SESSION['flash'] = [];
        return $data;
    }

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    /**
     * @param $key
     */
    public static function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function destroy()
    {
        session_destroy();
    }

    public function __destruct()
    {
        session_write_close();
    }
}