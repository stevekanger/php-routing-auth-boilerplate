<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\App;
use App\Core\Session;
use App\Core\Request;

class Authenticator {
    public static function login(string $email, string $password) {
        $db = App::get('App\Core\Database');
        $user = $db->query('SELECT * from users where email = :email', [
            'email' => $email
        ])->fetch();

        if (!$user) return false;

        $compared = password_verify($password, $user['password']);

        if (!$compared) return false;

        self::setUser($user);
        return true;
    }

    public static function setUser(array $user) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email']
        ];

        session_regenerate_id(true);
    }

    public static function logout($redirect = '/') {
        Session::destroy();
        Request::redirect($redirect);
    }
}
