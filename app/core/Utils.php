<?php

declare(strict_types=1);

namespace App\Core;

class Utils {
    public static function log(mixed ...$items) {
        $backtrace = debug_backtrace();
        $caller = array_shift($backtrace);
        echo '<pre style="padding: 10px; border: 1px solid black;">';
        echo 'File: ' . $caller['file'] . ' On line: ' . strval($caller['line']) . '<br>';
        foreach ($items as $item) {
            echo '<br>' . var_export($item, true) . '<br>';
        }
        echo '</pre>';
    }

    public static function performance(string $name = 'Test', callable $fn) {
        $times = [];
        $start = microtime(true);
        for ($i = 0; $i < 1000; $i++) {
            $fn();
        }
        $end = microtime(true);
        $times['1000'] = $start - $end;

        $start = microtime(true);
        for ($i = 0; $i < 10000; $i++) {
            $fn();
        }
        $start = microtime(true);
        $times['10000'] = $start - $end;

        $start = microtime(true);
        for ($i = 0; $i < 100000; $i++) {
            $fn();
        }
        $start = microtime(true);
        $times['100000'] = $start - $end;

        self::log($name, $times);
    }
}
