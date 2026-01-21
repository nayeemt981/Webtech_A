<?php
session_start();
require_once('../model/adminModel.php');

if($_SESSION['user_type'] != 'admin'){
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$data = $_POST['data'];
$decoded = json_decode($data, true);

$job_id = $decoded['job_id'];
$status = $decoded['status'];

$result = updateJobStatus($job_id, $status);

if($result){
    $message = ($status == 'approved') ? 'Job post approved successfully!' : 'Job post rejected!';
    echo json_encode(['success' => true, 'message' => $message]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status!']);
}
?>
