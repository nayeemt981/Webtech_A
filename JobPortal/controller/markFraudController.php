<?php
session_start();
require_once('../model/adminModel.php');

if($_SESSION['user_type'] != 'admin'){
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$data = $_POST['data'];
$decoded = json_decode($data, true);

$user_id = $decoded['user_id'];

$result = markUserAsFraud($user_id);

if($result){
    echo json_encode(['success' => true, 'message' => 'User marked as fraud and blocked!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to mark as fraud!']);
}
?>
