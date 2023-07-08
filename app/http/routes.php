<?php

declare(strict_types=1);

use App\Core\Router;
use App\Core\View;
use App\Controllers\Home;
use App\Controllers\About;
use App\Controllers\Register;
use App\Controllers\Login;
use App\Controllers\Logout;
use App\Controllers\Dashboard;
use App\Middleware\Auth;

Router::get('/', [Home::class, 'get']);
Router::get('/about', [About::class, 'get']);
Router::get('/register', [Register::class, 'get']);
Router::post('/register', [Register::class, 'post']);
Router::get('/login', [Login::class, 'get']);
Router::post('/login', [Login::class, 'post']);
Router::get('/logout', [Logout::class, 'get']);
Router::get('/dashboard/{id}', [Auth::class, 'isAuthenticated'],  [Dashboard::class, 'get']);

Router::any('.*', function () {
    View::show('general', [
        'title' => '404'
    ]);
});
