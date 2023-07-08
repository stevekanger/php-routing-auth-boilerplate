<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Request;
use Closure;

class Router {
    protected static $routes = [];

    public static function get(string $path, array|callable ...$callbacks) {
        self::add('GET', $path, ...$callbacks);
    }

    public static function post(string $path, array|callable ...$callbacks) {
        self::add('POST', $path, ...$callbacks);
    }

    public static function put(string $path, array|callable ...$callbacks) {
        self::add('PUT', $path, ...$callbacks);
    }

    public static function patch(string $path, array|callable ...$callbacks) {
        self::add('PATCH', $path, ...$callbacks);
    }

    public static function delete(string $path, array|callable ...$callbacks) {
        self::add('DELETE', $path, ...$callbacks);
    }

    public static function any(string $path, callable ...$callbacks) {
        $method = strtoupper($_POST['_method'] ?? $_SERVER['REQUEST_METHOD']);
        self::add($method, $path, ...$callbacks);
    }

    private static function add(string $method, string $path, array|callable ...$callbacks) {
        self::$routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callbacks' => $callbacks
        ];
    }

    public static function resolve() {
        foreach (self::$routes as $route) {
            if (Request::matchRoute($route)) {
                $next = self::next($route['callbacks'], 1);
                self::call($route['callbacks'][0], $next);
                break;
            }
        }
    }

    private static function next(array $callbacks, int $current) {
        return function () use ($callbacks, $current) {
            if (!$callbacks[$current]) {
                exit();
            }

            $next = self::next($callbacks, $current + 1);
            self::call($callbacks[$current], $next);
        };
    }

    private static function call(callable|array $controller, Closure $next) {
        if (is_callable($controller)) {
            $controller($next);
            return;
        }

        if (is_array($controller)) {
            call_user_func_array([(new $controller[0]), $controller[1]], [$next]);
        }
    }
}
