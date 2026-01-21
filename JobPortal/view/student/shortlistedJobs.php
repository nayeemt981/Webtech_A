<?php
session_start();
require_once('../../model/jobModel.php');
require_once('../../model/studentModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'student'){
    header('location: ../login.php?error=badrequest');
    exit();
}

// Get student ID
$conn = getConnection();
$student = getStudentProfile($conn, $_SESSION['user_id']);

if(!$student){
    echo "Error: Student profile not found";
    exit();
}

// Get shortlisted jobs
$shortlisted = getShortlistedJobs($student['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shortlisted Jobs - Student</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Student</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewJobListing.php">View Jobs</a>
        <a href="shortlistedJobs.php">Shortlisted</a>
        <a href="viewApplicationStatus.php">Applications</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>My Shortlisted Jobs</h2>
        
        <?php if(count($shortlisted) == 0): ?>
            <div class="alert alert-info">You haven't shortlisted any jobs yet.</div>
        <?php else: ?>
        <div id="job_results">
            <?php foreach($shortlisted as $job): ?>
            <div class="job-card">
                <h3><?=$job['job_title']?></h3>
                <p class="company-name"><?=$job['company_name']?></p>
                
                <div class="job-details">
                    <p><strong>Category:</strong> <?=$job['job_category']?></p>
                    <p><strong>Type:</strong> <?=$job['job_type']?></p>
                    <p><strong>Location:</strong> <?=$job['location']?></p>
                    <p><strong>Salary:</strong> <?=$job['salary_range']?></p>
                    <p><strong>Deadline:</strong> <?=$job['deadline']?></p>
                    <p><strong>Shortlisted On:</strong> <?=$job['shortlisted_at']?></p>
                </div>
                
                <p><?=substr($job['description'], 0, 200)?>...</p>
                
                <div class="button-group">
                    <button onclick="applyJob(<?=$job['job_id']?>)" class="btn btn-primary">Apply</button>
                    <button onclick="removeFromShortlist(<?=$job['job_id']?>)" class="btn btn-danger">Remove</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
