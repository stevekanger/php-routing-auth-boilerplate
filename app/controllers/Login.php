<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Core\Authenticator;
use App\Core\Request;
use App\Core\Session;

class Login {
    public function get() {
        if (Session::has('user')) {
            Request::redirect('/dashboard/123');
        }

        View::show('login', [
            'method' => 'GET'
        ]);
    }

    public function post() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $msg = 'Invalid. Please check your email and password.';

        $isValid = Authenticator::login($email, $password);

        if ($isValid) $msg = 'User logged in successfully!';

        View::show('login', [
            'method' => 'POST',
            'msg' => $msg
        ]);
    }
}
