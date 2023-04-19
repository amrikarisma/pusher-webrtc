<?php
require_once('loader.php');

if (isset($_POST)) {
    if (isset($_POST['email'])) {
        set_user_login($_POST['email']);
    }
}
?>
<html>

<head>
    <title>Login - Video Call with Pusher and WebRTC</title>

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
            <h2>Login</h2>
            <form action="" method="post">
                <div style="display: flex;gap:15px; ">
                    <input type="email" name="email" placeholder="Email">

                    <button type="submit">Login</button>
                </div>
            </form>
            <div>
                <p style="font-weight: bold;color:red;">
                    <?php
                    if (isset($_SESSION['login_error'])) {
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']);
                    }
                    ?>
                </p>
            </div>
            <a href="register.php">Register</a>
        </div>
    </div>
</body>

</html>