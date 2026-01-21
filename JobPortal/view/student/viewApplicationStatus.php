<?php
session_start();
require_once('../../model/jobModel.php');
require_once('../../model/studentModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'student'){
    header('location: ../login.php?error=badrequest');
    exit();
}

// Get student ID from user_id
$conn = getConnection();
$student = getStudentProfile($conn, $_SESSION['user_id']);

if(!$student){
    echo "Error: Student profile not found";
    exit();
}

$applications = getStudentApplications($student['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Application Status - Student</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Student</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewJobListing.php">View Jobs</a>
        <a href="viewApplicationStatus.php">Applications</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>My Job Applications</h2>
        
        <?php if(count($applications) == 0): ?>
        <div class="alert alert-info">
            No applications yet. <a href="viewJobListing.php">Browse Jobs</a>
        </div>
        <?php else: ?>
        <table>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Applied Date</th>
                <th>Status</th>
            </tr>
            <?php foreach($applications as $app): ?>
            <tr>
                <td><?=$app['job_title']?></td>
                <td><?=$app['company_name']?></td>
                <td><?=date('M d, Y', strtotime($app['applied_date']))?></td>
                <td>
                    <?php
                    if($app['application_status'] == 'applied'){
                        echo "<span class='status status-pending'>Applied</span>";
                    } elseif($app['application_status'] == 'shortlisted'){
                        echo "<span class='status status-approved'>Shortlisted</span>";
                    } elseif($app['application_status'] == 'interview_scheduled'){
                        echo "<span class='status status-approved'>Interview Scheduled</span>";
                    } elseif($app['application_status'] == 'selected'){
                        echo "<span class='status status-approved'>Selected</span>";
                    } elseif($app['application_status'] == 'rejected'){
                        echo "<span class='status status-rejected'>Rejected</span>";
                    }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
