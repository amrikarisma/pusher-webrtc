<?php
$servername = "mysql";
$database = "webrtc_test";
$username = "user";
$password = "password";
// Create connection
$db = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully";
// mysqli_close($db);
