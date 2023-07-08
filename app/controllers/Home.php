<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

class Home {
    public function get() {
        View::show('home', [
            'title' => 'Made it to Home Page!'
        ]);
    }
}
