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

// Get all shortlisted candidates for this company's jobs
$conn = getConnection();
$shortlisted = getShortlistedCandidates($conn, $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shortlisted Candidates - Job Portal</title>
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
        <h2>Shortlisted Candidates</h2>
        
        <?php if(count($shortlisted) > 0){ ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Candidate Name</th>
                        <th>Job Title</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Degree</th>
                        <th>University</th>
                        <th>Experience</th>
                        <th>Skills</th>
                        <th>Application Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($shortlisted as $candidate){ ?>
                        <tr>
                            <td><?=$candidate['full_name']?></td>
                            <td><?=$candidate['job_title']?></td>
                            <td><?=$candidate['email']?></td>
                            <td><?=$candidate['phone']?></td>
                            <td><?=$candidate['degree']?></td>
                            <td><?=$candidate['university']?></td>
                            <td><?=$candidate['experience']?></td>
                            <td><?=$candidate['skills']?></td>
                            <td><?=$candidate['applied_at']?></td>
                            <td><?=$candidate['application_status']?></td>
                            <td>
                                <?php if($candidate['resume_path']){ ?>
                                    <a href="../../<?=$candidate['resume_path']?>" target="_blank" class="btn btn-info">View Resume</a>
                                <?php } ?>
                                <?php if($candidate['application_status'] == 'shortlisted'){ ?>
                                    <a href="scheduleInterviewForm.php?application_id=<?=$candidate['application_id']?>" class="btn btn-primary">Schedule Interview</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No candidates shortlisted yet.</p>
        <?php } ?>
    </div>
</body>
</html>
