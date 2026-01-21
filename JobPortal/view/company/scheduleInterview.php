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

// Get all interviews scheduled by this company
$conn = getConnection();
$interviews = getCompanyInterviews($conn, $_SESSION['user_id']);

// Get success/error messages
$success = isset($_REQUEST['success']) ? $_REQUEST['success'] : '';
$error = isset($_REQUEST['error']) ? $_REQUEST['error'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Interviews - Job Portal</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
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
        <h2>Interview Schedule</h2>
        
        <?php if($success){ ?>
            <div class="success-msg"><?=$success?></div>
        <?php } ?>
        
        <?php if($error){ ?>
            <div class="error-msg"><?=$error?></div>
        <?php } ?>
        
        <h3>Scheduled Interviews</h3>
        
        <?php if(count($interviews) > 0){ ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Applicant Name</th>
                        <th>Job Title</th>
                        <th>Interview Date</th>
                        <th>Interview Time</th>
                        <th>Interview Type</th>
                        <th>Location/Link</th>
                        <th>Result</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($interviews as $interview){ ?>
                        <tr>
                            <td><?=$interview['student_name']?></td>
                            <td><?=$interview['job_title']?></td>
                            <td><?=$interview['interview_date']?></td>
                            <td><?=$interview['interview_time']?></td>
                            <td><?=$interview['interview_type']?></td>
                            <td><?=$interview['location']?></td>
                            <td><?=$interview['result'] ? $interview['result'] : 'Pending'?></td>
                            <td>
                                <?php if(!$interview['result']){ ?>
                                    <button onclick="updateInterviewResult(<?=$interview['interview_id']?>, 'selected')" class="btn btn-success">Select</button>
                                    <button onclick="updateInterviewResult(<?=$interview['interview_id']?>, 'rejected')" class="btn btn-danger">Reject</button>
                                <?php } else { ?>
                                    <span><?=$interview['result']?></span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No interviews scheduled yet.</p>
        <?php } ?>
    </div>
</body>
</html>
