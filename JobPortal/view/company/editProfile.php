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

// Get success/error messages
$success = isset($_REQUEST['success']) ? $_REQUEST['success'] : '';
$error = isset($_REQUEST['error']) ? $_REQUEST['error'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile - Job Portal</title>
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
        <h2>Edit Company Profile</h2>
        
        <?php if($success){ ?>
            <div class="success-msg"><?=$success?></div>
        <?php } ?>
        
        <?php if($error){ ?>
            <div class="error-msg"><?=$error?></div>
        <?php } ?>
        
        <form action="../../controller/updateCompanyProfileController.php" method="POST" onsubmit="return validateCompanyProfile()">
            <table>
                <tr>
                    <td>Company Name:</td>
                    <td><input type="text" name="company_name" id="company_name" value="<?=$company['company_name']?>" required></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" id="email" value="<?=$company['email']?>" required></td>
                </tr>
                <tr>
                    <td>Industry:</td>
                    <td><input type="text" name="industry" id="industry" value="<?=$company['industry']?>" required></td>
                </tr>
                <tr>
                    <td>Location:</td>
                    <td><input type="text" name="location" id="location" value="<?=$company['location']?>" required></td>
                </tr>
                <tr>
                    <td>Website:</td>
                    <td><input type="url" name="website" id="website" value="<?=$company['website']?>"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" id="description" rows="5" required><?=$company['description']?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Update Profile" class="btn btn-primary">
                        <a href="profile.php" class="btn btn-secondary">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
