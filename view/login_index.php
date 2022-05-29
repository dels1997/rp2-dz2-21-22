<?php require_once __DIR__ . '/login_header.php'; ?>

    <form method="POST" action="teamup.php">
    Username (or e-mail):
    <input type="text" name="username"></br>
    Password:
    <input type="password" name="password"></br>
    <button type="submit" name="login">Login!</button></br>
    <button type="submit" name="register">Register!</button>
    </form>

<?php require_once __DIR__ . '/_footer.php'; ?>