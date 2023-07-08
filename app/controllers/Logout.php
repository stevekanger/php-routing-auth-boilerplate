<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Authenticator;

class Logout {
    public function get() {
        Authenticator::logout();
    }
}
