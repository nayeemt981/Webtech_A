<?php
session_start();
require_once('../model/loginModel.php');

$username = trim($_REQUEST['username']);
$password = trim($_REQUEST['password']);
$remember = isset($_REQUEST['remember']) ? $_REQUEST['remember'] : '';

if($username == "" || $password == ""){
    header('location: ../view/login.php?error=null');
    exit();
}

$data = ['username' => $username, 'password' => $password];
$user = loginUser($data);

if($user){
    // Check if account is approved
    if($user['status'] == 'blocked'){
        header('location: ../view/login.php?error=blocked');
        exit();
    }
    
    if($user['status'] == 'pending'){
        header('location: ../view/login.php?error=pending');
        exit();
    }
    
    if($user['status'] == 'rejected'){
        header('location: ../view/login.php?error=rejected');
        exit();
    }
    
    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_type'] = $user['user_type'];
    $_SESSION['profile_id'] = $user['profile_id'];
    
    // Set cookie for authentication
    setcookie('status', 'true', time()+3600, '/');
    
    // Set remember me cookie
    if($remember == 'yes'){
        setcookie('remember_user', $username, time()+(86400 * 30), '/');
    }
    
    // Redirect based on user type
    if($user['user_type'] == 'student'){
        header('location: ../view/student/dashboard.php');
    } elseif($user['user_type'] == 'company'){
        header('location: ../view/company/dashboard.php');
    } elseif($user['user_type'] == 'counselor'){
        header('location: ../view/counselor/dashboard.php');
    } elseif($user['user_type'] == 'admin'){
        header('location: ../view/admin/dashboard.php');
    }
} else {
    header('location: ../view/login.php?error=invalid');
}
?>
