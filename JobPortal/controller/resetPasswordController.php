<?php
require_once('../model/changePasswordModel.php');

$email = trim($_REQUEST['email']);
$new_password = trim($_REQUEST['new_password']);
$confirm_password = trim($_REQUEST['confirm_password']);

if($email == "" || $new_password == "" || $confirm_password == ""){
    header('location: ../view/resetPassword.php?error=null');
    exit();
}

if(strpos($email, '@') === false || strpos($email, '.') === false){
    header('location: ../view/resetPassword.php?error=invalid_email');
    exit();
}

if($new_password != $confirm_password){
    header('location: ../view/resetPassword.php?error=mismatch');
    exit();
}

if(strlen($new_password) < 6){
    header('location: ../view/resetPassword.php?error=short');
    exit();
}

$status = resetUserPassword($email, $new_password);

if($status){
    header('location: ../view/login.php?success=password_reset');
} else {
    header('location: ../view/resetPassword.php?error=email_not_found');
}
?>
