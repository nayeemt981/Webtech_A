<?php
session_start();
require_once('../model/companyModel.php');

if(!isset($_SESSION['profile_id'])){
    header('location: ../view/company/dashboard.php');
    exit();
}

$job_id = trim($_REQUEST['job_id']);

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
    header('location: ../view/company/editJobPost.php?id=' . $job_id . '&error=null');
    exit();
}

$status = updateJobPost($job_id, $data);

if($status){
    header('location: ../view/company/editJobPost.php?id=' . $job_id . '&success=updated');
} else {
    header('location: ../view/company/editJobPost.php?id=' . $job_id . '&error=failed');
}
?>
