<?php
require_once('loader.php');

if (isset($_POST)) {
    if (isset($_POST['email'])) {
        set_user_login($_POST['email']);
    }
}

if (isset($_SESSION['login_error'])) {
    echo $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>
<div style="display: flex;gap:25px;">
    <div>
        <h2>Login</h2>
        <form action="" method="post">
            <div style="display: flex;gap:15px;">
                <input type="email" name="email" placeholder="Email">
                <button type="submit">Login</button>
            </div>
        </form>
        <a href="register.php">Register</a>
    </div>
</div>