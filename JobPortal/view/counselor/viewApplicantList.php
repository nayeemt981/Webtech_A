<?php
session_start();
require_once('../../model/counselorModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'counselor'){
    header('location: ../login.php?error=badrequest');
    exit();
}

// Get counselor ID from user_id
$conn = getConnection();
$counselor = getCounselorByUserId($conn, $_SESSION['user_id']);

if(!$counselor){
    echo "Error: Counselor profile not found";
    exit();
}

// Get all appointments to extract unique students
$appointments = getCounselorAppointments($counselor['id']);

// Group by student to show unique applicants
$students = array();
foreach($appointments as $app){
    $student_id = $app['student_id'];
    if(!isset($students[$student_id])){
        $students[$student_id] = array(
            'full_name' => $app['full_name'],
            'email' => $app['email'],
            'phone' => $app['phone'],
            'total_consultations' => 0,
            'last_consultation' => $app['appointment_date']
        );
    }
    $students[$student_id]['total_consultations']++;
    
    // Update last consultation date if this one is more recent
    if($app['appointment_date'] > $students[$student_id]['last_consultation']){
        $students[$student_id]['last_consultation'] = $app['appointment_date'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Applicant List - Counselor</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Counselor</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="receiveAppointment.php">Appointments</a>
        <a href="viewSessionList.php">Session History</a>
        <a href="viewApplicantList.php">Applicant List</a>
        <a href="changePassword.php">Change Password</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Student Applicant List</h2>
        <p>List of students who have consulted with you</p>
        
        <?php if(count($students) == 0): ?>
        <div class="alert alert-info">No student applicants yet.</div>
        <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Consultations</th>
                    <th>Last Consultation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($students as $student): ?>
                <tr>
                    <td><?=$student['full_name']?></td>
                    <td><?=$student['email']?></td>
                    <td><?=$student['phone']?></td>
                    <td><?=$student['total_consultations']?></td>
                    <td><?=$student['last_consultation']?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
