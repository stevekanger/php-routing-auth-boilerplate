<h1>Register</h1>

<?php if ($data['method'] == 'GET') : ?>
    <form action="/register" method="POST">
        <input type="email" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="Passoword" />
        <button type="submit">Submit</button>
    </form>
<?php else : ?>
    <p><?php echo $data['msg'] ?></p>
<?php endif ?>