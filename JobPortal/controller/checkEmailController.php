<?php
require_once('../model/loginModel.php');

$data = $_POST['data'];
$decoded = json_decode($data, true);

$email = trim($decoded['email']);

$exists = checkEmailExists($email);

$response = ['exists' => $exists];

echo json_encode($response);
?>
