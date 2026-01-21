<?php
session_start();

// Check authentication
if(!isset($_COOKIE['status'])){
    header('location: ../login.php?error=badrequest');
    exit();
}

// Check if student
if($_SESSION['user_type'] != 'student'){
    header('location: ../login.php?error=badrequest');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - Job Portal</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Student</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="editResume.php">Resume</a>
        <a href="viewJobListing.php">View Jobs</a>
        <a href="shortlistedJobs.php">Shortlisted Jobs</a>
        <a href="viewApplicationStatus.php">Applications</a>
        <a href="viewCounselors.php">Counselors</a>
        <a href="changePassword.php">Change Password</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <div class="dashboard">
            <div class="dashboard-header">
                <h1>Welcome, <?=$_SESSION['username']?>!</h1>
                <p>Find your dream job and build your career</p>
            </div>
            
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Profile Completion</h3>
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress_fill" style="width: 0%;">
                            <span id="completion_percentage">0%</span>
                        </div>
                    </div>
                    <p><a href="profile.php">Complete Your Profile</a></p>
                </div>
                
                <div class="card">
                    <h3>Resume</h3>
                    <p>Keep your resume updated</p>
                    <a href="editResume.php" class="btn btn-primary">Edit Resume</a>
                </div>
                
                <div class="card">
                    <h3>Video Resume</h3>
                    <p>Upload your video introduction</p>
                    <a href="uploadVideoResume.php" class="btn btn-primary">Upload Video</a>
                </div>
                
                <div class="card">
                    <h3>Job Opportunities</h3>
                    <p>Browse and apply for jobs</p>
                    <a href="viewJobListing.php" class="btn btn-primary">View Jobs</a>
                </div>
                
                <div class="card">
                    <h3>Career Counseling</h3>
                    <p>Get guidance from experts</p>
                    <a href="viewCounselors.php" class="btn btn-primary">View Counselors</a>
                </div>
                
                <div class="card">
                    <h3>Applications</h3>
                    <p>Track your job applications</p>
                    <a href="viewApplicationStatus.php" class="btn btn-primary">View Status</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Load profile completion on page load
        window.onload = function(){
            calculateProfileCompletion();
        }
    </script>
</body>
</html>
