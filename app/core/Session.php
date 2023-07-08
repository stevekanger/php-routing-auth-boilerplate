<?php

declare(strict_types=1);

namespace App\Core;

use Closure;

class Session {
    public static function has(string $key) {
        return (bool) static::get($key);
    }

    public static function set(string $key, mixed $value) {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $default = null) {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    public static function flash(string $key, mixed $value) {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash() {
        unset($_SESSION['_flash']);
    }

    public static function flush() {
        $_SESSION = [];
    }

    public static function destroy() {
        self::flush();

        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
