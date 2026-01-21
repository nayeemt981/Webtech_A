<?php
require_once('../model/db.php');

function registerUser($data){
    $con = getConnection();
    
    $username = mysqli_real_escape_string($con, $data['username']);
    $email = mysqli_real_escape_string($con, $data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $user_type = mysqli_real_escape_string($con, $data['user_type']);
    
    // Set status based on user type
    if($user_type == 'student' || $user_type == 'admin'){
        $status = 'approved';
    } else {
        $status = 'pending';
    }
    
    $sql = "INSERT INTO users (username, email, password, user_type, status) 
            VALUES ('{$username}', '{$email}', '{$password}', '{$user_type}', '{$status}')";
    
    if(mysqli_query($con, $sql)){
        $user_id = mysqli_insert_id($con);
        
        // Create profile in respective table
        if($user_type == 'student'){
            $full_name = mysqli_real_escape_string($con, $data['full_name']);
            $phone = mysqli_real_escape_string($con, $data['phone']);
            $sql2 = "INSERT INTO students (user_id, full_name, phone) VALUES ('{$user_id}', '{$full_name}', '{$phone}')";
            mysqli_query($con, $sql2);
        } elseif($user_type == 'company'){
            $company_name = mysqli_real_escape_string($con, $data['company_name']);
            $location = mysqli_real_escape_string($con, $data['location']);
            $sql2 = "INSERT INTO companies (user_id, company_name, location) VALUES ('{$user_id}', '{$company_name}', '{$location}')";
            mysqli_query($con, $sql2);
        } elseif($user_type == 'counselor'){
            $full_name = mysqli_real_escape_string($con, $data['full_name']);
            $specialization = mysqli_real_escape_string($con, $data['specialization']);
            $sql2 = "INSERT INTO counselors (user_id, full_name, specialization) VALUES ('{$user_id}', '{$full_name}', '{$specialization}')";
            mysqli_query($con, $sql2);
        }
        
        return true;
    }
    return false;
}
?>
