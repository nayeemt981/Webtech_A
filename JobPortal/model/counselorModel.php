<?php
require_once('db.php');

function getAllCounselors(){
    $con = getConnection();
    $sql = "SELECT c.*, u.username, u.email, u.status FROM counselors c
            JOIN users u ON c.user_id = u.id
            WHERE u.status = 'approved'
            ORDER BY c.full_name";
    $result = mysqli_query($con, $sql);
    
    $counselors = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($counselors, $row);
    }
    return $counselors;
}

function applyForConsultation($student_id, $counselor_id, $data){
    $con = getConnection();
    
    $appointment_date = mysqli_real_escape_string($con, $data['appointment_date']);
    $appointment_time = mysqli_real_escape_string($con, $data['appointment_time']);
    $session_mode = mysqli_real_escape_string($con, $data['session_mode']);
    $student_notes = mysqli_real_escape_string($con, $data['student_notes']);
    
    $sql = "INSERT INTO consultations (student_id, counselor_id, appointment_date, appointment_time, session_mode, student_notes, status)
            VALUES ({$student_id}, {$counselor_id}, '{$appointment_date}', '{$appointment_time}', '{$session_mode}', '{$student_notes}', 'requested')";
    
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}

function getCounselorAppointments($counselor_id){
    $con = getConnection();
    $sql = "SELECT co.*, s.full_name, s.phone, u.email FROM consultations co
            JOIN students s ON co.student_id = s.id
            JOIN users u ON s.user_id = u.id
            WHERE co.counselor_id = {$counselor_id}
            ORDER BY co.created_at DESC";
    $result = mysqli_query($con, $sql);
    
    $appointments = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($appointments, $row);
    }
    return $appointments;
}

function updateConsultationStatus($consultation_id, $status){
    $con = getConnection();
    $status = mysqli_real_escape_string($con, $status);
    
    $sql = "UPDATE consultations SET status = '{$status}' WHERE id = {$consultation_id}";
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}

function addFeedback($consultation_id, $counselor_id, $student_id, $feedback_text, $rating){
    $con = getConnection();
    
    $feedback_text = mysqli_real_escape_string($con, $feedback_text);
    $rating = (int)$rating;
    
    $sql = "INSERT INTO feedback (consultation_id, counselor_id, student_id, feedback_text, rating)
            VALUES ({$consultation_id}, {$counselor_id}, {$student_id}, '{$feedback_text}', {$rating})";
    
    if(mysqli_query($con, $sql)){
        $sql2 = "UPDATE consultations SET status = 'completed' WHERE id = {$consultation_id}";
        mysqli_query($con, $sql2);
        return true;
    }
    return false;
}

function getCounselorById($conn, $counselor_id){
    $sql = "SELECT c.*, u.username, u.email FROM counselors c
            JOIN users u ON c.user_id = u.id
            WHERE c.id = {$counselor_id}";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getCounselorByUserId($conn, $user_id){
    $sql = "SELECT c.*, u.username, u.email FROM counselors c
            JOIN users u ON c.user_id = u.id
            WHERE c.user_id = {$user_id}";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}
?>
