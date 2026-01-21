<?php
session_start();
require_once('../model/companyModel.php');

if(!isset($_SESSION['profile_id'])){
    header('location: ../view/company/dashboard.php');
    exit();
}

$data = [
    'job_title' => trim($_REQUEST['job_title']),
    'job_category' => trim($_REQUEST['job_category']),
    'job_type' => trim($_REQUEST['job_type']),
    'salary_range' => trim($_REQUEST['salary_range']),
    'location' => trim($_REQUEST['location']),
    'description' => trim($_REQUEST['description']),
    'requirements' => trim($_REQUEST['requirements']),
    'deadline' => trim($_REQUEST['deadline'])
];

if($data['job_title'] == "" || $data['job_category'] == "" || $data['job_type'] == "" || $data['location'] == "" || $data['description'] == ""){
    header('location: ../view/company/createJobPost.php?error=null');
    exit();
}

$status = createJobPost($_SESSION['profile_id'], $data);

if($status){
    header('location: ../view/company/createJobPost.php?success=created');
} else {
    header('location: ../view/company/createJobPost.php?error=failed');
}
?>
