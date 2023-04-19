<?php

require_once('loader.php');
if (isset($_POST)) {
    if (isset($_POST['email'])) {
        set_user_register($_POST);
    }
}

if (isset($_SESSION['login_error'])) {
    echo $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>
<html>

<head>
    <title>Register - Video Call with Pusher and WebRTC</title>
    <style>
        body {
            background-color: #141a36;
            color: #fff;
        }

        a {
            color: #fff;
        }

        form {
            text-align: center;
        }
    </style>
</head>

<body>
    <div style="display: flex;gap:25px;justify-content:center;align-items:center;height:100%;">
        <div>
            <h2>Register</h2>
            <form action="" method="post">
                <input type="text" name="name" placeholder="Name">
                <input type="email" name="email" placeholder="Email">
                <button type="submit">Register</button>
            </form>
            <a href="login.php">Login</a>
        </div>
    </div>
</body>

</html>