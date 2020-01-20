<?php

namespace App;

class Session
{

    public static function setFlash($key, $value)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[$key] = $value;
    }

    public static function getFlash($key)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (self::hasFlash($key)) {
            $flash = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $flash;
        }
        return null;
    }

    public static function hasFlash($key): bool
    {
        if (isset($_SESSION[$key])) {
            return true;
        }
        return false;
    }
}
