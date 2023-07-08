<?php

declare(strict_types=1);

use App\Core\Router;

ini_set('session.cookie_lifetime', (require __DIR__ . '/../app/config.php')['session']['lifetime']);

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/../app/http/routes.php';

// Must call resolve after declaring all routes
Router::resolve();
