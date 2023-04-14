<?php
require_once('loader.php');
try {
    if (!isset($_POST['socket_id'])) {
        return;
    }

    $options = array(
        'cluster' => $_ENV['APP_CLUSTER'],
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        $_ENV['APP_KEY'],
        $_ENV['APP_SECRET'],
        $_ENV['APP_ID'],
        $options
    );
    $userId = (string)rand(1000, 9999) . strtotime("now");
    $presence_data = array('id' => rand(1, 99), 'user_id' => $userId);
    header('Content-Type: application/json; charset=utf-8');
    // echo $pusher->authorizeChannel($_POST['channel_name'], $_POST['socket_id']);
    $pusher->authenticateUser($_POST['socket_id'], $presence_data);
    echo $pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], $presence_data['user_id']);
    // echo json_encode($_POST['socket_id']);
    die();
} catch (\Throwable $th) {
    print_r($th->getMessage());
}
