<?php
session_start();

// Check authentication
if(!isset($_COOKIE['status'])){
    header('location: ../login.php?error=badrequest');
    exit();
}

// Check if counselor
if($_SESSION['user_type'] != 'counselor'){
    header('location: ../login.php?error=badrequest');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Counselor Dashboard - Job Portal</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Career Counselor</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="receiveAppointment.php">Appointments</a>
        <a href="viewSessionList.php">Sessions</a>
        <a href="viewApplicantList.php">Students</a>
        <a href="changePassword.php">Change Password</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <div class="dashboard">
            <div class="dashboard-header">
                <h1>Welcome, <?=$_SESSION['username']?>!</h1>
                <p>Guide students towards successful careers</p>
            </div>
            
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Appointment Requests</h3>
                    <p>View student consultation requests</p>
                    <a href="receiveAppointment.php" class="btn btn-primary">View Requests</a>
                </div>
                
                <div class="card">
                    <h3>Create Session</h3>
                    <p>Schedule consultation sessions</p>
                    <a href="createConsultation.php" class="btn btn-primary">Create Session</a>
                </div>
                
                <div class="card">
                    <h3>View Sessions</h3>
                    <p>Manage all consultation sessions</p>
                    <a href="viewSessionList.php" class="btn btn-primary">View Sessions</a>
                </div>
                
                <div class="card">
                    <h3>Review Resumes</h3>
                    <p>Provide resume feedback</p>
                    <a href="reviewResume.php" class="btn btn-primary">Review</a>
                </div>
                
                <div class="card">
                    <h3>Provide Feedback</h3>
                    <p>Give career guidance feedback</p>
                    <a href="feedbackSession.php" class="btn btn-primary">Give Feedback</a>
                </div>
                
                <div class="card">
                    <h3>Track Placements</h3>
                    <p>Monitor student placement status</p>
                    <a href="trackPlacement.php" class="btn btn-primary">Track</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
