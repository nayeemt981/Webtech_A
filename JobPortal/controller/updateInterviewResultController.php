<?php
session_start();
require_once('../model/companyModel.php');

if(!isset($_SESSION['profile_id'])){
    echo json_encode(['success' => false, 'message' => 'Session expired']);
    exit();
}

$data = $_POST['data'];
$decoded = json_decode($data, true);

$interview_id = $decoded['interview_id'];
$result = $decoded['result'];

$status = updateInterviewResult($interview_id, $result);

if($status){
    echo json_encode(['success' => true, 'message' => 'Interview result updated!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update!']);
}
?>
