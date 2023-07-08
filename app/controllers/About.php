<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

class About {
    public function get() {
        View::show('about', [
            'title' => 'And now for about',
            'desc' => 'Here is a quick description'
        ]);
    }
}
