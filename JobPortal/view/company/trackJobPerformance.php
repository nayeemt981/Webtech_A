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

require_once('../../model/companyModel.php');

// Get job performance statistics
$conn = getConnection();
$stats = getJobPerformanceStats($conn, $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Performance - Job Portal</title>
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
        <h2>Job Post Performance Statistics</h2>
        
        <?php if(count($stats) > 0){ ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Posted Date</th>
                        <th>Status</th>
                        <th>Total Applications</th>
                        <th>Shortlisted</th>
                        <th>Interviews Scheduled</th>
                        <th>Selected</th>
                        <th>Rejected</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($stats as $stat){ ?>
                        <tr>
                            <td><?=$stat['job_title']?></td>
                            <td><?=$stat['created_at']?></td>
                            <td><?=$stat['status']?></td>
                            <td><?=$stat['total_applications']?></td>
                            <td><?=$stat['shortlisted_count']?></td>
                            <td><?=$stat['interview_count']?></td>
                            <td><?=$stat['selected_count']?></td>
                            <td><?=$stat['rejected_count']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <div class="stats-summary">
                <h3>Overall Statistics</h3>
                <?php
                $total_apps = 0;
                $total_shortlisted = 0;
                $total_interviews = 0;
                $total_selected = 0;
                foreach($stats as $stat){
                    $total_apps += $stat['total_applications'];
                    $total_shortlisted += $stat['shortlisted_count'];
                    $total_interviews += $stat['interview_count'];
                    $total_selected += $stat['selected_count'];
                }
                ?>
                <p><strong>Total Applications Received:</strong> <?=$total_apps?></p>
                <p><strong>Total Shortlisted:</strong> <?=$total_shortlisted?></p>
                <p><strong>Total Interviews Conducted:</strong> <?=$total_interviews?></p>
                <p><strong>Total Selected:</strong> <?=$total_selected?></p>
            </div>
        <?php } else { ?>
            <p>No job posts yet. Create a job post to see statistics.</p>
        <?php } ?>
    </div>
</body>
</html>
