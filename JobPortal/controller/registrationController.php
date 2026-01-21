<?php
session_start();
require_once('../model/registrationModel.php');
require_once('../model/loginModel.php');

$username = isset($_REQUEST['username']) ? trim($_REQUEST['username']) : '';
$email = isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
$password = isset($_REQUEST['password']) ? trim($_REQUEST['password']) : '';
$confirm_password = isset($_REQUEST['confirm_password']) ? trim($_REQUEST['confirm_password']) : '';
$user_type = isset($_REQUEST['user_type']) ? trim($_REQUEST['user_type']) : '';

// Validation
if($username == "" || $email == "" || $password == "" || $confirm_password == "" || $user_type == ""){
    header('location: ../view/registration.php?error=null');
    exit();
}

// Check email format
if(strpos($email, '@') === false || strpos($email, '.') === false){
    header('location: ../view/registration.php?error=invalid_email');
    exit();
}

// Check password match
if($password != $confirm_password){
    header('location: ../view/registration.php?error=password_mismatch');
    exit();
}

// Check if username exists
if(checkUsernameExists($username)){
    header('location: ../view/registration.php?error=username_exists');
    exit();
}

// Check if email exists
if(checkEmailExists($email)){
    header('location: ../view/registration.php?error=email_exists');
    exit();
}

// Prepare data based on user type
$data = [
    'username' => $username,
    'email' => $email,
    'password' => $password,
    'user_type' => $user_type
];

if($user_type == 'student'){
    $data['full_name'] = isset($_REQUEST['student_full_name']) ? trim($_REQUEST['student_full_name']) : '';
    $data['phone'] = isset($_REQUEST['student_phone']) ? trim($_REQUEST['student_phone']) : '';
    
    if($data['full_name'] == "" || $data['phone'] == ""){
        header('location: ../view/registration.php?error=null');
        exit();
    }
} elseif($user_type == 'company'){
    $data['company_name'] = isset($_REQUEST['company_name']) ? trim($_REQUEST['company_name']) : '';
    $data['location'] = isset($_REQUEST['location']) ? trim($_REQUEST['location']) : '';
    
    if($data['company_name'] == "" || $data['location'] == ""){
        header('location: ../view/registration.php?error=null');
        exit();
    }
} elseif($user_type == 'counselor'){
    $data['full_name'] = isset($_REQUEST['counselor_full_name']) ? trim($_REQUEST['counselor_full_name']) : '';
    $data['specialization'] = isset($_REQUEST['counselor_specialization']) ? trim($_REQUEST['counselor_specialization']) : '';
    
    if($data['full_name'] == "" || $data['specialization'] == ""){
        header('location: ../view/registration.php?error=null');
        exit();
    }
}

// Register user
$status = registerUser($data);

if($status){
    if($user_type == 'student'){
        header('location: ../view/login.php?success=registered');
    } else {
        header('location: ../view/login.php?success=pending_approval');
    }
} else {
    header('location: ../view/registration.php?error=failed');
}
?>
