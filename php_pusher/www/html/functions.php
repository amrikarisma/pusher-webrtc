<?php

function get_user()
{
    global $db;
    $email = $_SESSION['user']['email'];
    $sql = "SELECT * FROM `users` WHERE `email` LIKE '{$email}'";
    $query = mysqli_query($db, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}

function set_user_login($email)
{
    global $db;
    $sql = "SELECT * FROM `users` WHERE `email` LIKE '{$email}'";
    $query = mysqli_query($db, $sql);
    $result = mysqli_fetch_assoc($query);
    if ($result) {
        $_SESSION['redirect_login'] = true;
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user'] = $result;
        header("Location: index.php");
    } else {
        $_SESSION['login_error'] = 'User not found';
    }
    return $result;
}

function set_user_register($post)
{
    global $db;
    $name = $post['name'];
    $email = $post['email'];
    $sql = "SELECT * FROM `users` WHERE `email` LIKE '{$email}'";
    $query = mysqli_query($db, $sql);
    $result = mysqli_fetch_assoc($query);
    if (!$result) {
        $sql = "INSERT INTO users (name, email) VALUE ('$name', '$email')";
        $query = mysqli_query($db, $sql);
        if ($query) {
            $_SESSION['redirect_login'] = true;
            header("Location: login.php");
        } else {
            $_SESSION['login_error'] = 'Register failed';
        }
    } else {
        $_SESSION['login_error'] = 'Email already exists';
    }
    return $query;
}
