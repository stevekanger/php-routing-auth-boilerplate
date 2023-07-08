# Simple routing and auth php boilerplate

Simple routing and auth boilerplate for php projects with no libraries.

## Usage

<b>Composer required.</b>

Download the zip file run `composer init`. Followed by `composer dump-autoload`. Then for development you can run `composer dev`.

Change your database info and session lifetime in `app/config.php`.

```php
return [
    'db' => [
        'dbname' => 'your database name',
        'user' => 'your database user',
        'pass' => 'your database pass',
        'host' => 'localhost',
        'port' => 3306,
        'charset' => 'utf8mb4',
    ],
    'session' => [
        'lifetime' => strval(60 * 60 * 24 * 7), // 7 Days
    ]
];

```

Next you will need the following database tables so run the sql query below.

### Users table

This will hold the users for authentication. The id will start at 1 and auto increment.

```sql
CREATE TABLE users(
    id int PRIMARY KEY AUTO_INCREMENT,
  	email varchar(320) NOT NULL UNIQUE,
  	password varchar(255) NOT NULL,
    isAdmin boolean DEFAULT false
) AUTO_INCREMENT = 1;
```

## Routing

Routes are currently specified in `http/routes.php`. You can specify a route with the following syntax.

```php
use App\Core\Router;

Router::get('/path', function() {
  echo "We made it!";
});
```

You can use `Router::get`, `Router::post`, `Router::put`, `Router::patch`, `Router::delete`, `Router::any`.

You may also use classes for your controller.

```php
class YourController {
  public function get() {
    echo 'yay!';
  }
}

```

then in routes

```php
// namespace of your controller
use App\Controllers\YourController;

Route::get('/', [YourController::class, 'get']);
```

### Router matching

The router will match the first available match and anything after will be ignored. So take the following example.

```php
Router::get('/', function() {
  echo 'foo';
});
Router::get('/', function() {
  echo 'bar';
});
```

This will only echo `foo` and ignore the following matched route.

### Router Params

You can catch router parameters by placing then in brackets `{id}`. Then you can get the params by using the `Request::class`.

```php
use App\Core\Request;

Router::get('/dashboard/{userid}', function() {
  // get all params
  $params = Request::getParams():

  // get single param
  $userid = Request::getParam('userid'):
});
```

### Router Middleware

The router can take multiple controllers after the path is stated. Each controller function will be called with `$next` as an argument. You can chain as many of these together as you like and just call `$next()` when your ready to proceed.

#### Router

```php

use App\Controllers\Dashboard;
use App\Middleware\Auth;

Router::get('/dashboard', [Auth::class, 'isAuthenticated'], [Dashboard::class, 'get'] );
```

#### Middleware

```php
class Auth {
  public function isAuthenticated($next) {
      if (!$_SESSION['user'] ?? false) {
        Request::redirect('/login');
      }
     $next();
  }
}
```

### 404 Page

You can do a simple catchall after stating all of your routes like so:

```php
Router::get('.*', function() {
  View::show('404');
});
```

## Views

The `View` class has only one static method and that is `View::show`. All views must be placed in the views folder and the path is relative to that folder and minus the `.php` extension. So if you want to show the `about.php` view then place it in `views/about.php` then you can just call `View::show('about');`.

You can also pass data to your view. You can do so by passing a second paramater as an array. Then you can acces that by using the `$data` variable in your view like so:

```php
use App\Core\View;

Router::get('/about', function() {
  View::show('about', [
    'title' => 'About Page'
  ]);
});
```

Then in `about.php`.

```php
<h1><?php echo $data['title']; ?></h1>
```

## Database

The database is bootstrapped into the App class as a container. You can access it by calling `App::get('App\Core\Database');`. So if you want to get all users you can do:

```php
use App\Core\App;

$db = App::get('App\Core\Database');

// query the database
$query = $db->query('SELECT * from users');

// fetch
$user = $db->query('SELECT * from users')->fetch();

// fetchAll
$user = $db->query('SELECT * from users')->fetchAll();

// fetch of fail (this kills page execution and exits).
$user = $db->query('SELECT * from users')->fetchOrFail();
```

### Pass query params for prepared statements

You can pass your query params as the second argument in the query to avoid sql injection.

```php
$id = 1;
$user = $db->query('SELECT * from users WHERE id = :id', [':id' => $id])
```

## Liscense MIT

Take a look at the core folder and use what you like. This is a very basic boilerplate with simple core functionality. Take/Add whatever you like.
