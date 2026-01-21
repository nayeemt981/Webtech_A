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

// Get company profile
$conn = getConnection();
$company = getCompanyById($conn, $_SESSION['user_id']);

if(!$company){
    echo "Error loading profile";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Company Profile - Job Portal</title>
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
        <h2>Company Profile</h2>
        
        <div class="profile-section">
            <h3>Company Information</h3>
            <div class="profile-info">
                <p><strong>Company Name:</strong> <?=$company['company_name']?></p>
                <p><strong>Username:</strong> <?=$_SESSION['username']?></p>
                <p><strong>Email:</strong> <?=$company['email']?></p>
                <p><strong>Industry:</strong> <?=$company['industry']?></p>
                <p><strong>Location:</strong> <?=$company['location']?></p>
                <p><strong>Website:</strong> <?=$company['website']?></p>
                <p><strong>Description:</strong> <?=$company['description']?></p>
            </div>
            
            <a href="editProfile.php" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
</body>
</html>
