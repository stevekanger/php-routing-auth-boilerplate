<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Database;

App::init();

App::set('App\Core\Database', function () {
    return new Database((require 'config.php')['db']);
});
