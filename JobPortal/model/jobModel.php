<?php
require_once('db.php');

function getAllApprovedJobs(){
    $con = getConnection();
    $sql = "SELECT j.*, c.company_name FROM jobs j
            JOIN companies c ON j.company_id = c.id
            WHERE j.status = 'approved' AND j.is_active = 1
            ORDER BY j.created_at DESC";
    $result = mysqli_query($con, $sql);
    
    $jobs = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($jobs, $row);
    }
    return $jobs;
}

function searchJobs($keyword, $category){
    $con = getConnection();
    $keyword = mysqli_real_escape_string($con, $keyword);
    $category = mysqli_real_escape_string($con, $category);
    
    $sql = "SELECT j.*, c.company_name FROM jobs j
            JOIN companies c ON j.company_id = c.id
            WHERE j.status = 'approved' AND j.is_active = 1";
    
    if($keyword != ""){
        $sql .= " AND (j.job_title LIKE '%{$keyword}%' OR j.description LIKE '%{$keyword}%')";
    }
    
    if($category != ""){
        $sql .= " AND j.job_category = '{$category}'";
    }
    
    $sql .= " ORDER BY j.created_at DESC";
    
    $result = mysqli_query($con, $sql);
    
    $jobs = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($jobs, $row);
    }
    return $jobs;
}

function addToShortlist($student_id, $job_id){
    $con = getConnection();
    
    // Check if already shortlisted
    $sql = "SELECT id FROM shortlisted_jobs WHERE student_id = {$student_id} AND job_id = {$job_id}";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0){
        return false;
    }
    
    $sql2 = "INSERT INTO shortlisted_jobs (student_id, job_id) VALUES ({$student_id}, {$job_id})";
    if(mysqli_query($con, $sql2)){
        return true;
    }
    return false;
}

function applyForJob($student_id, $job_id, $cover_letter){
    $con = getConnection();
    $cover_letter = mysqli_real_escape_string($con, $cover_letter);
    
    // Check if already applied
    $sql = "SELECT id FROM applications WHERE student_id = {$student_id} AND job_id = {$job_id}";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0){
        return false;
    }
    
    $sql2 = "INSERT INTO applications (job_id, student_id, cover_letter) 
             VALUES ({$job_id}, {$student_id}, '{$cover_letter}')";
    if(mysqli_query($con, $sql2)){
        return true;
    }
    return false;
}

function getStudentApplications($student_id){
    $con = getConnection();
    $sql = "SELECT a.*, j.job_title, c.company_name 
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            JOIN companies c ON j.company_id = c.id
            WHERE a.student_id = {$student_id}
            ORDER BY a.applied_date DESC";
    $result = mysqli_query($con, $sql);
    
    $applications = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($applications, $row);
    }
    return $applications;
}

function getShortlistedJobs($student_id){
    $con = getConnection();
    $sql = "SELECT sj.*, j.*, c.company_name, sj.created_at as shortlisted_at
            FROM shortlisted_jobs sj
            JOIN jobs j ON sj.job_id = j.id
            JOIN companies c ON j.company_id = c.id
            WHERE sj.student_id = {$student_id}
            ORDER BY sj.created_at DESC";
    $result = mysqli_query($con, $sql);
    
    $jobs = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($jobs, $row);
    }
    return $jobs;
}

function removeFromShortlist($student_id, $job_id){
    $con = getConnection();
    $sql = "DELETE FROM shortlisted_jobs WHERE student_id = {$student_id} AND job_id = {$job_id}";
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}
?>
