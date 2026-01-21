<?php
session_start();
require_once('../model/jobModel.php');
require_once('../model/studentModel.php');

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'student'){
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Get student ID from user_id
$conn = getConnection();
$student = getStudentProfile($conn, $_SESSION['user_id']);

if(!$student){
    echo json_encode(['success' => false, 'message' => 'Student profile not found']);
    exit();
}

$data = $_POST['data'];
$decoded = json_decode($data, true);

$job_id = $decoded['job_id'];

$status = addToShortlist($student['id'], $job_id);

if($status){
    echo json_encode(['success' => true, 'message' => 'Job shortlisted successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Already shortlisted or failed!']);
}
?>
