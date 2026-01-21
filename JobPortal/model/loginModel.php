<?php
require_once('../model/db.php');

function loginUser($data){
    $con = getConnection();
    $username = mysqli_real_escape_string($con, $data['username']);
    
    $sql = "SELECT u.*, 
            CASE 
                WHEN u.user_type = 'student' THEN s.id
                WHEN u.user_type = 'company' THEN c.id
                WHEN u.user_type = 'counselor' THEN co.id
                ELSE NULL
            END as profile_id
            FROM users u
            LEFT JOIN students s ON u.id = s.user_id AND u.user_type = 'student'
            LEFT JOIN companies c ON u.id = c.user_id AND u.user_type = 'company'
            LEFT JOIN counselors co ON u.id = co.user_id AND u.user_type = 'counselor'
            WHERE u.username = '{$username}'";
    
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) == 1){
        $user = mysqli_fetch_assoc($result);
        
        if(password_verify($data['password'], $user['password'])){
            return $user;
        }
    }
    return false;
}

function checkUsernameExists($username){
    $con = getConnection();
    $username = mysqli_real_escape_string($con, $username);
    
    $sql = "SELECT id FROM users WHERE username = '{$username}'";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0){
        return true;
    }
    return false;
}

function checkEmailExists($email){
    $con = getConnection();
    $email = mysqli_real_escape_string($con, $email);
    
    $sql = "SELECT id FROM users WHERE email = '{$email}'";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0){
        return true;
    }
    return false;
}
?>
