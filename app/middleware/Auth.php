<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use Closure;

class Auth {
    public function isAuthenticated(Closure $next) {
        if (!$_SESSION['user'] ?? false) {
            Request::redirect('/login');
        }

        $next();
    }
}
