<?php
require_once('../model/loginModel.php');

$data = $_POST['data'];
$decoded = json_decode($data, true);

$username = trim($decoded['username']);

$exists = checkUsernameExists($username);

$response = ['exists' => $exists];

echo json_encode($response);
?>
