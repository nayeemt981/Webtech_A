<?php
session_start();

// Check authentication
if(!isset($_COOKIE['status'])){
    header('location: ../view/login.php?error=badrequest');
    exit();
}

// Check if student
if($_SESSION['user_type'] != 'student'){
    header('location: ../view/login.php?error=badrequest');
    exit();
}

require_once('../model/counselorModel.php');
require_once('../model/studentModel.php');

// Get form data
$counselor_id = isset($_REQUEST['counselor_id']) ? trim($_REQUEST['counselor_id']) : '';
$preferred_date = isset($_REQUEST['preferred_date']) ? trim($_REQUEST['preferred_date']) : '';
$preferred_time = isset($_REQUEST['preferred_time']) ? trim($_REQUEST['preferred_time']) : '';
$session_mode = isset($_REQUEST['session_mode']) ? trim($_REQUEST['session_mode']) : '';
$consultation_topic = isset($_REQUEST['consultation_topic']) ? trim($_REQUEST['consultation_topic']) : '';
$message = isset($_REQUEST['message']) ? trim($_REQUEST['message']) : '';

// Validation
if(empty($counselor_id) || empty($preferred_date) || empty($preferred_time) || empty($session_mode) || empty($consultation_topic) || empty($message)){
    header('location: ../view/student/applyConsultation.php?id='.$counselor_id.'&error=All fields required');
    exit();
}

// Get student ID from database
$conn = getConnection();
$student = getStudentProfile($conn, $_SESSION['user_id']);

if(!$student){
    header('location: ../view/student/viewCounselors.php?error=Student profile not found');
    exit();
}

// Prepare data - combine topic and message
$student_notes = "Topic: " . $consultation_topic . "\n\n" . $message;

$data = [
    'appointment_date' => $preferred_date,
    'appointment_time' => $preferred_time,
    'session_mode' => $session_mode,
    'student_notes' => $student_notes
];

// Book consultation
if(applyForConsultation($student['id'], $counselor_id, $data)){
    header('location: ../view/student/viewCounselors.php?success=Consultation request sent successfully');
} else {
    header('location: ../view/student/applyConsultation.php?id='.$counselor_id.'&error=Failed to book consultation');
}
?>
