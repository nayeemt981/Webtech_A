<?php
session_start();
require_once('../../model/companyModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'company'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$conn = getConnection();
$applicants = getJobApplicants($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Applicants - Company</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Company</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewApplicantList.php">Applicants</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Job Applicants</h2>
        
        <?php if(count($applicants) == 0): ?>
        <div class="alert alert-info">No applicants yet.</div>
        <?php else: ?>
        <table>
            <tr>
                <th>Applicant Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Job Title</th>
                <th>Applied Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($applicants as $app): ?>
            <tr>
                <td><?=$app['full_name']?></td>
                <td><?=$app['email']?></td>
                <td><?=$app['phone']?></td>
                <td><?=$app['job_title']?></td>
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
                <td>
                    <?php if($app['resume_file'] != ""): ?>
                    <a href="../../asset/uploads/resumes/<?=$app['resume_file']?>" target="_blank">View Resume</a> |
                    <?php endif; ?>
                    <button onclick="shortlistCandidate(<?=$app['id']?>)" class="btn btn-primary">Shortlist</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
