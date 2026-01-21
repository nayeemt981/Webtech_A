<?php
session_start();

// Check authentication
if(!isset($_COOKIE['status'])){
    header('location: ../view/login.php?error=badrequest');
    exit();
}

// Check if company
if($_SESSION['user_type'] != 'company'){
    header('location: ../view/login.php?error=badrequest');
    exit();
}

require_once('../model/companyModel.php');

// Get form data
$application_id = isset($_REQUEST['application_id']) ? trim($_REQUEST['application_id']) : '';
$interview_date = isset($_REQUEST['interview_date']) ? trim($_REQUEST['interview_date']) : '';
$interview_time = isset($_REQUEST['interview_time']) ? trim($_REQUEST['interview_time']) : '';
$interview_type = isset($_REQUEST['interview_type']) ? trim($_REQUEST['interview_type']) : '';
$location = isset($_REQUEST['location']) ? trim($_REQUEST['location']) : '';
$notes = isset($_REQUEST['notes']) ? trim($_REQUEST['notes']) : '';

// Validation
if(empty($application_id) || empty($interview_date) || empty($interview_time) || empty($interview_type) || empty($location)){
    header('location: ../view/company/scheduleInterviewForm.php?application_id='.$application_id.'&error=All fields required');
    exit();
}

// Prepare data
$data = [
    'interview_date' => $interview_date,
    'interview_time' => $interview_time,
    'interview_mode' => $interview_type,
    'interview_link' => ($interview_type == 'Online') ? $location : '',
    'interview_location' => ($interview_type != 'Online') ? $location : '',
    'notes' => $notes
];

// Schedule interview
if(scheduleInterview($application_id, $data)){
    header('location: ../view/company/scheduleInterview.php?success=Interview scheduled successfully');
} else {
    header('location: ../view/company/scheduleInterviewForm.php?application_id='.$application_id.'&error=Failed to schedule interview');
}
?>
