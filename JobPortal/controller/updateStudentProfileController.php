<?php
session_start();
require_once('../model/studentModel.php');

if(!isset($_SESSION['profile_id'])){
    header('location: ../view/student/dashboard.php');
    exit();
}

$data = [
    'full_name' => trim($_REQUEST['full_name']),
    'phone' => trim($_REQUEST['phone']),
    'address' => trim($_REQUEST['address']),
    'degree' => trim($_REQUEST['degree']),
    'university' => trim($_REQUEST['university']),
    'graduation_year' => trim($_REQUEST['graduation_year']),
    'skills' => trim($_REQUEST['skills']),
    'experience' => trim($_REQUEST['experience'])
];

$status = updateStudentProfile($_SESSION['profile_id'], $data);

if($status){
    calculateProfileCompletion($_SESSION['profile_id']);
    header('location: ../view/student/profile.php?success=updated');
} else {
    header('location: ../view/student/profile.php?error=failed');
}
?>
