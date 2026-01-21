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

// Get application ID
$application_id = isset($_REQUEST['application_id']) ? $_REQUEST['application_id'] : '';

if(!$application_id){
    header('location: shortlistedCandidates.php?error=Invalid application');
    exit();
}

require_once('../../model/companyModel.php');

// Get application details
$conn = getConnection();
$application = getApplicationById($conn, $application_id);

if(!$application){
    header('location: shortlistedCandidates.php?error=Application not found');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Schedule Interview - Job Portal</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/validation.js"></script>
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
        <h2>Schedule Interview</h2>
        
        <div class="profile-section">
            <h3>Candidate Information</h3>
            <p><strong>Name:</strong> <?=$application['full_name']?></p>
            <p><strong>Job:</strong> <?=$application['job_title']?></p>
            <p><strong>Email:</strong> <?=$application['email']?></p>
        </div>
        
        <form action="../../controller/scheduleInterviewController.php" method="POST" onsubmit="return validateInterviewForm()">
            <input type="hidden" name="application_id" value="<?=$application_id?>">
            
            <table>
                <tr>
                    <td>Interview Date:</td>
                    <td><input type="date" name="interview_date" id="interview_date" required></td>
                </tr>
                <tr>
                    <td>Interview Time:</td>
                    <td><input type="time" name="interview_time" id="interview_time" required></td>
                </tr>
                <tr>
                    <td>Interview Type:</td>
                    <td>
                        <select name="interview_type" id="interview_type" required>
                            <option value="">Select Type</option>
                            <option value="In-person">In-person</option>
                            <option value="Online">Online</option>
                            <option value="Phone">Phone</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Location/Link:</td>
                    <td><input type="text" name="location" id="location" placeholder="Office address or meeting link" required></td>
                </tr>
                <tr>
                    <td>Additional Notes:</td>
                    <td><textarea name="notes" id="notes" rows="4" placeholder="Optional notes for candidate"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Schedule Interview" class="btn btn-primary">
                        <a href="shortlistedCandidates.php" class="btn btn-secondary">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
