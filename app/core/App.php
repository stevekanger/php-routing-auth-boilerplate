<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Container;

class App {
    protected static $container;
    protected static $initalized = false;

    public static function init() {
        if (self::$initalized) return;

        self::$container = new Container();
        self::$initalized = true;
    }

    public static function get(string $key) {
        return self::$container->get($key);
    }

    public static function set(string $key, callable $resolver) {
        self::$container->set($key, $resolver);
    }
}
