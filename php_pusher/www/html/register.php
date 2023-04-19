<?php

require_once('loader.php');
if (isset($_POST)) {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        set_user_register($_POST);
    }
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
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">Register</button>
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
            <a href="login.php">Login</a>
        </div>
    </div>
</body>

</html>