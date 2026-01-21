<?php
session_start();
require_once('../model/studentModel.php');

if(!isset($_SESSION['profile_id'])){
    header('location: ../view/student/dashboard.php');
    exit();
}

if(!isset($_FILES['video_file']) || $_FILES['video_file']['error'] == 4){
    header('location: ../view/student/uploadVideoResume.php?error=no_file');
    exit();
}

$file = $_FILES['video_file'];
$file_name = $file['name'];
$file_tmp = $file['tmp_name'];
$file_size = $file['size'];
$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

$allowed = ['mp4', 'avi', 'mov', 'wmv'];

if(!in_array($file_ext, $allowed)){
    header('location: ../view/student/uploadVideoResume.php?error=invalid_type');
    exit();
}

if($file_size > 52428800){
    header('location: ../view/student/uploadVideoResume.php?error=large_file');
    exit();
}

$new_file_name = 'video_' . $_SESSION['profile_id'] . '_' . time() . '.' . $file_ext;
$upload_path = '../asset/uploads/videos/' . $new_file_name;

if(move_uploaded_file($file_tmp, $upload_path)){
    $status = uploadVideoResume($_SESSION['profile_id'], $new_file_name);
    if($status){
        calculateProfileCompletion($_SESSION['profile_id']);
        header('location: ../view/student/uploadVideoResume.php?success=uploaded');
    } else {
        header('location: ../view/student/uploadVideoResume.php?error=upload_failed');
    }
} else {
    header('location: ../view/student/uploadVideoResume.php?error=upload_failed');
}
?>
