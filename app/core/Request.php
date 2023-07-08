<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\View;

// Simplest version of a Request class basically just processes the params and gets URI/METHOD - Add methods as needed.
class Request {
    private static $params = [];

    public static function getParam(string $key) {
        return self::$params[$key] ?? null;
    }

    public static function getParams() {
        return self::$params;
    }

    private static function setParams(array $params) {
        self::$params = $params;
    }

    public static function matchRoute(array $route) {
        $method = self::getMethod();
        $uri =  rtrim(self::getUri(), "/");
        $path = $route['path'] == "/" ? '' : $route['path'];
        $pattern = "@^" . preg_replace('/{(.*?)}+/', '([a-zA-Z0-9\-\_]+)', $path) . "$@D";
        $paramValues = [];
        $match = preg_match($pattern, $uri, $paramValues);
        if ($method == $route['method'] && $match) {
            $paramKeys = [];
            preg_match_all('/{(.*?)}+/', $path, $paramKeys);
            array_shift($paramValues);
            $params = array_combine(array_values($paramKeys[1]), array_values($paramValues));
            self::setParams($params);
            return true;
        }
        return false;
    }


    public static function getMethod() {
        return $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    }

    public static function getUri() {
        return parse_url($_SERVER['REQUEST_URI'])['path'];
    }

    public static function redirect(string $path) {
        header('Location: ' . $path);
        exit();
    }

    public static function abort(int $code) {
        http_response_code($code);
        View::show('error', [
            'error' => $code
        ]);
        die();
    }
}
