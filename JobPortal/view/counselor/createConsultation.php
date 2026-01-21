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

// Get pending appointments count
$query = "SELECT COUNT(*) as count FROM consultations WHERE counselor_id = {$counselor['id']} AND status = 'requested'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$pending_count = $row['count'];

// Get completed appointments count
$query = "SELECT COUNT(*) as count FROM consultations WHERE counselor_id = {$counselor['id']} AND status = 'completed'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$completed_count = $row['count'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Consultation Session - Counselor</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Counselor</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="receiveAppointment.php">Appointments</a>
        <a href="viewSessionList.php">Session History</a>
        <a href="createConsultation.php">Create Session</a>
        <a href="changePassword.php">Change Password</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Consultation Management</h2>
        <p>Students book consultation appointments with you directly</p>
        
        <div class="profile-section">
            <h3>How Consultations Work</h3>
            <p>Students initiate consultation requests through the "Book Consultation" feature on their dashboard. You will receive these requests and can approve or manage them.</p>
            
            <div style="margin: 20px 0;">
                <h4>Your Consultation Statistics:</h4>
                <div class="profile-info">
                    <p><strong>Pending Requests:</strong> <?=$pending_count?></p>
                    <p><strong>Completed Sessions:</strong> <?=$completed_count?></p>
                </div>
            </div>
            
            <div style="margin-top: 20px;">
                <a href="receiveAppointment.php" style="padding: 10px 20px; background-color: #0066cc; color: white; text-decoration: none; border-radius: 4px; display: inline-block; margin-right: 10px;">View Appointments</a>
                <a href="feedbackSession.php" style="padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px; display: inline-block; margin-right: 10px;">Provide Feedback</a>
                <a href="dashboard.php" style="padding: 10px 20px; background-color: #666; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">Back to Dashboard</a>
            </div>
        </div>
        
        <div class="profile-section" style="margin-top: 20px;">
            <h3>Counselor Profile Information</h3>
            <div class="profile-info">
                <p><strong>Name:</strong> <?=$counselor['full_name']?></p>
                <p><strong>Specialization:</strong> <?=$counselor['specialization']?></p>
                <p><strong>Experience:</strong> <?=$counselor['experience_years']?> years</p>
                <p><strong>Qualification:</strong> <?=$counselor['qualification']?></p>
            </div>
        </div>
    </div>
</body>
</html>
