<?php
session_start();

// Check authentication
if(!isset($_COOKIE['status'])){
    header('location: ../login.php?error=badrequest');
    exit();
}

// Check if company
if($_SESSION['user_type'] != 'company'){
    header('location: ../login.php?error=badrequest');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Company Dashboard - Job Portal</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Company</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="viewJobPostList.php">My Job Posts</a>
        <a href="createJobPost.php">Create Job Post</a>
        <a href="viewApplicantList.php">Applicants</a>
        <a href="scheduleInterview.php">Interviews</a>
        <a href="changePassword.php">Change Password</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <div class="dashboard">
            <div class="dashboard-header">
                <h1>Welcome, <?=$_SESSION['username']?>!</h1>
                <p>Recruit talented candidates for your company</p>
            </div>
            
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Create Job Post</h3>
                    <p>Post new job opportunities</p>
                    <a href="createJobPost.php" class="btn btn-primary">Create Post</a>
                </div>
                
                <div class="card">
                    <h3>Manage Job Posts</h3>
                    <p>View and edit your job posts</p>
                    <a href="viewJobPostList.php" class="btn btn-primary">View Posts</a>
                </div>
                
                <div class="card">
                    <h3>View Applicants</h3>
                    <p>Review job applications</p>
                    <a href="viewApplicantList.php" class="btn btn-primary">View Applicants</a>
                </div>
                
                <div class="card">
                    <h3>Schedule Interviews</h3>
                    <p>Manage interview schedules</p>
                    <a href="scheduleInterview.php" class="btn btn-primary">Schedule</a>
                </div>
                
                <div class="card">
                    <h3>Shortlisted Candidates</h3>
                    <p>View shortlisted applicants</p>
                    <a href="shortlistedCandidates.php" class="btn btn-primary">View List</a>
                </div>
                
                <div class="card">
                    <h3>Track Performance</h3>
                    <p>View job post statistics</p>
                    <a href="trackJobPerformance.php" class="btn btn-primary">View Stats</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
