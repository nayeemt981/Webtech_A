<?php
require_once('db.php');

function getAllUsers(){
    $con = getConnection();
    $sql = "SELECT u.*, 
            CASE 
                WHEN u.user_type = 'student' THEN s.full_name
                WHEN u.user_type = 'company' THEN c.company_name
                WHEN u.user_type = 'counselor' THEN co.full_name
                ELSE u.username
            END as display_name
            FROM users u
            LEFT JOIN students s ON u.id = s.user_id AND u.user_type = 'student'
            LEFT JOIN companies c ON u.id = c.user_id AND u.user_type = 'company'
            LEFT JOIN counselors co ON u.id = co.user_id AND u.user_type = 'counselor'
            ORDER BY u.created_at DESC";
    $result = mysqli_query($con, $sql);
    
    $users = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($users, $row);
    }
    return $users;
}

function getPendingCompanies(){
    $con = getConnection();
    $sql = "SELECT u.*, c.* FROM users u
            JOIN companies c ON u.id = c.user_id
            WHERE u.user_type = 'company' AND u.status = 'pending'
            ORDER BY u.created_at DESC";
    $result = mysqli_query($con, $sql);
    
    $companies = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($companies, $row);
    }
    return $companies;
}

function getPendingCounselors(){
    $con = getConnection();
    $sql = "SELECT u.*, c.* FROM users u
            JOIN counselors c ON u.id = c.user_id
            WHERE u.user_type = 'counselor' AND u.status = 'pending'
            ORDER BY u.created_at DESC";
    $result = mysqli_query($con, $sql);
    
    $counselors = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($counselors, $row);
    }
    return $counselors;
}

function getPendingJobPosts(){
    $con = getConnection();
    $sql = "SELECT j.*, c.company_name FROM jobs j
            JOIN companies c ON j.company_id = c.id
            WHERE j.status = 'pending'
            ORDER BY j.created_at DESC";
    $result = mysqli_query($con, $sql);
    
    $jobs = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($jobs, $row);
    }
    return $jobs;
}

function updateUserStatus($user_id, $status){
    $con = getConnection();
    $status = mysqli_real_escape_string($con, $status);
    
    $sql = "UPDATE users SET status = '{$status}' WHERE id = {$user_id}";
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}

function updateJobStatus($job_id, $status){
    $con = getConnection();
    $status = mysqli_real_escape_string($con, $status);
    
    $sql = "UPDATE jobs SET status = '{$status}' WHERE id = {$job_id}";
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}

function markUserAsFraud($user_id){
    $con = getConnection();
    
    $sql = "UPDATE users SET is_fraud = 1, status = 'blocked' WHERE id = {$user_id}";
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}
?>
