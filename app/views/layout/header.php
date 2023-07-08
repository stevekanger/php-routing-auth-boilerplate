<?php
$user = $_SESSION['user']['email'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth Boilerplate</title>
    <link rel="stylesheet" href="/style.css">
</head>
<div class="container">
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/about">About</a></li>
            <?php if (!$user) : ?>
                <li><a href="/register">Register</a></li>
                <li><a href="/login">Login</a></li>
            <?php else : ?>
                <li><a href="/dashboard/<?php echo $_SESSION['user']['id'] ?? null ?>">Dashboard</a></li>
                <li><a href="/logout">Logout</a></li>
            <?php endif; ?>
        </ul>

        <p>User: <?php echo $user ?? 'Guest' ?></p>
    </nav>
</div>

<body>
    <div class="container">