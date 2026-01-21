<?php
session_start();
require_once('../model/companyModel.php');

if(!isset($_SESSION['profile_id'])){
    echo json_encode(['success' => false, 'message' => 'Session expired']);
    exit();
}

$data = $_POST['data'];
$decoded = json_decode($data, true);

$application_id = $decoded['application_id'];

$status = shortlistCandidate($_SESSION['profile_id'], $application_id);

if($status){
    echo json_encode(['success' => true, 'message' => 'Candidate shortlisted successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to shortlist!']);
}
?>
