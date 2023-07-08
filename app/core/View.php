<?php

declare(strict_types=1);

namespace App\Core;

class View {
    protected static $viewsFolder = __DIR__ . '/../views/';

    public static function show(string $view, array $data = null) {
        include self::$viewsFolder . 'layout/header.php';
        include self::$viewsFolder . $view . '.php';
        include self::$viewsFolder . 'layout/footer.php';
    }
}
