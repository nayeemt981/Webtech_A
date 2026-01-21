<?php
require_once('db.php');

function getStudentProfile($conn, $user_id){
    $sql = "SELECT s.*, u.username, u.email FROM students s 
            JOIN users u ON s.user_id = u.id 
            WHERE s.user_id = {$user_id}";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function updateStudentProfile($student_id, $data){
    $con = getConnection();
    
    $full_name = mysqli_real_escape_string($con, $data['full_name']);
    $phone = mysqli_real_escape_string($con, $data['phone']);
    $address = mysqli_real_escape_string($con, $data['address']);
    $degree = mysqli_real_escape_string($con, $data['degree']);
    $university = mysqli_real_escape_string($con, $data['university']);
    $graduation_year = mysqli_real_escape_string($con, $data['graduation_year']);
    $skills = mysqli_real_escape_string($con, $data['skills']);
    $experience = mysqli_real_escape_string($con, $data['experience']);
    
    $sql = "UPDATE students SET 
            full_name = '{$full_name}',
            phone = '{$phone}',
            address = '{$address}',
            degree = '{$degree}',
            university = '{$university}',
            graduation_year = '{$graduation_year}',
            skills = '{$skills}',
            experience = '{$experience}'
            WHERE id = {$student_id}";
    
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}

function calculateProfileCompletion($student_id){
    $con = getConnection();
    $sql = "SELECT * FROM students WHERE id = {$student_id}";
    $result = mysqli_query($con, $sql);
    $student = mysqli_fetch_assoc($result);
    
    $total_fields = 10;
    $filled_fields = 0;
    
    if($student['full_name'] != "") $filled_fields++;
    if($student['phone'] != "") $filled_fields++;
    if($student['address'] != "") $filled_fields++;
    if($student['degree'] != "") $filled_fields++;
    if($student['university'] != "") $filled_fields++;
    if($student['graduation_year'] != "") $filled_fields++;
    if($student['skills'] != "") $filled_fields++;
    if($student['experience'] != "") $filled_fields++;
    if($student['resume_file'] != "") $filled_fields++;
    if($student['video_resume'] != "") $filled_fields++;
    
    $percentage = ($filled_fields / $total_fields) * 100;
    
    // Update percentage in database
    $sql2 = "UPDATE students SET profile_completion = {$percentage} WHERE id = {$student_id}";
    mysqli_query($con, $sql2);
    
    return $percentage;
}

function uploadResume($student_id, $file_name){
    $con = getConnection();
    $file_name = mysqli_real_escape_string($con, $file_name);
    
    $sql = "UPDATE students SET resume_file = '{$file_name}' WHERE id = {$student_id}";
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}

function uploadVideoResume($student_id, $file_name){
    $con = getConnection();
    $file_name = mysqli_real_escape_string($con, $file_name);
    
    $sql = "UPDATE students SET video_resume = '{$file_name}' WHERE id = {$student_id}";
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}
?>
