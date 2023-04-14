<?php

require_once('loader.php');

use Twilio\Rest\Client;

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = $_ENV['TWILIO_ACCOUNT_SID'];
$token = $_ENV['TWILIO_AUTH_TOKEN'];
$twilio = new Client($sid, $token);

$token = $twilio->tokens->create();
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['iceServers' => $token->iceServers]);
die();
