<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;

class Dashboard {
    public function get() {
        View::show('dashboard', [
            'id' => Request::getParam('id'),
        ]);
    }
}
