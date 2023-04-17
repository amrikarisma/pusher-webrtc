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

    $user = get_user();
    if (isset($user['id'])) {
        $presence_data = $user;
        header('Content-Type: application/json; charset=utf-8');
        // echo $pusher->authorizeChannel($_POST['channel_name'], $_POST['socket_id']);
        // $pusher->authenticateUser($_POST['socket_id'], $presence_data);
        echo $pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], $presence_data['id'], $presence_data);
        // echo json_encode($_POST['socket_id']);
        die();
    } else {
        header('', true, 403);
        echo ("Forbidden");
    }
} catch (\Throwable $th) {
    print_r($th->getMessage());
}
