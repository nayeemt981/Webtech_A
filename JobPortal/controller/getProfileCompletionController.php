<?php
session_start();
require_once('../model/studentModel.php');

if(!isset($_SESSION['profile_id'])){
    header('location: ../view/student/dashboard.php');
    exit();
}

$percentage = calculateProfileCompletion($_SESSION['profile_id']);

$response = ['percentage' => round($percentage)];
echo json_encode($response);
?>
