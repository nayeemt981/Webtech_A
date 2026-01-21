<?php
session_start();
require_once('../model/companyModel.php');

if(!isset($_SESSION['profile_id'])){
    header('location: ../view/company/dashboard.php');
    exit();
}

$job_id = $_REQUEST['id'];
$status = deleteJobPost($job_id);

if($status){
    header('location: ../view/company/viewJobPostList.php?success=deleted');
} else {
    header('location: ../view/company/viewJobPostList.php?error=failed');
}
?>
