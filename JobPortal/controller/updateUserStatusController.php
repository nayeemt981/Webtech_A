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
$status = $decoded['status'];

$result = updateUserStatus($user_id, $status);

if($result){
    $message = ($status == 'approved') ? 'User approved successfully!' : 'User rejected!';
    echo json_encode(['success' => true, 'message' => $message]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status!']);
}
?>
