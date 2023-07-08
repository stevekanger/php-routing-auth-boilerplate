<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\View;
use App\Core\Session;
use App\Core\Request;

class Register {
    public function get() {
        if (Session::has('user')) {
            Request::redirect('/dashboard/123');
        }

        View::show('register', [
            "method" => 'GET',
        ]);
    }

    public function post() {
        $db = App::get('App\Core\Database');
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $db->query('SELECT * from users WHERE email = :email', [":email" => $email])->fetch();
        $msg = 'There is already a user with that email.';

        if (!$user) {
            $query = $db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ]);

            $msg = 'User created successfully!';
        }

        View::show('register', [
            'method' => 'POST',
            'msg' => $msg
        ]);
    }
}
