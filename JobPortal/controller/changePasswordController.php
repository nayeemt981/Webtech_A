<?php
session_start();
require_once('../model/changePasswordModel.php');

if(!isset($_SESSION['user_id'])){
    header('location: ../view/login.php?error=badrequest');
    exit();
}

$old_password = trim($_REQUEST['old_password']);
$new_password = trim($_REQUEST['new_password']);
$confirm_password = trim($_REQUEST['confirm_password']);

if($old_password == "" || $new_password == "" || $confirm_password == ""){
    header('location: ../view/' . $_SESSION['user_type'] . '/changePassword.php?error=null');
    exit();
}

if($new_password != $confirm_password){
    header('location: ../view/' . $_SESSION['user_type'] . '/changePassword.php?error=mismatch');
    exit();
}

if(strlen($new_password) < 6){
    header('location: ../view/' . $_SESSION['user_type'] . '/changePassword.php?error=short');
    exit();
}

$status = changeUserPassword($_SESSION['user_id'], $old_password, $new_password);

if($status){
    header('location: ../view/' . $_SESSION['user_type'] . '/changePassword.php?success=changed');
} else {
    header('location: ../view/' . $_SESSION['user_type'] . '/changePassword.php?error=wrong_password');
}
?>
