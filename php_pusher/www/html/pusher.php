<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
    require __DIR__ . '/vendor/autoload.php';

    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '4d99961ed8f70c04595a',
        '7bb62cafefb00cf0ca27',
        '1578165',
        $options
    );

    $user_data = [
        'user_id' => (string)rand(1000, 9999) . strtotime("now")
    ];

    header('Content-Type: application/json; charset=utf-8');
    echo $pusher->authorizeChannel($_POST['socket_id'], json_encode($user_data));
    // echo json_encode($_POST['socket_id']);
    die();
} catch (\Throwable $th) {
    print_r($th->getMessage());
}
