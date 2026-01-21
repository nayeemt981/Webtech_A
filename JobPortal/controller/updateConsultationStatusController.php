<?php
session_start();
require_once('../model/counselorModel.php');

if($_SESSION['user_type'] != 'counselor'){
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$data = $_POST['data'];
$decoded = json_decode($data, true);

$consultation_id = $decoded['consultation_id'];
$status = $decoded['status'];

$result = updateConsultationStatus($consultation_id, $status);

if($result){
    echo json_encode(['success' => true, 'message' => 'Consultation status updated!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update!']);
}
?>
