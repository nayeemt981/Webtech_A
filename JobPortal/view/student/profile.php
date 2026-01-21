<?php
session_start();
require_once('../../model/studentModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'student'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$conn = getConnection();
$student = getStudentProfile($conn, $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile - Student</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Student</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>My Profile</h2>
        
        <?php
        if(isset($_REQUEST['success']) && $_REQUEST['success'] == "updated"){
            echo "<div class='alert alert-success'>Profile updated successfully!</div>";
        }
        ?>
        
        <div class="card">
            <h3>Profile Completion: <?=$student['profile_completion']?>%</h3>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?=$student['profile_completion']?>%;">
                    <?=$student['profile_completion']?>%
                </div>
            </div>
        </div>
        
        <form method="post" action="../../controller/updateStudentProfileController.php">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="full_name" value="<?=$student['full_name']?>" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="text" value="<?=$student['email']?>" disabled>
            </div>
            
            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" value="<?=$student['phone']?>">
            </div>
            
            <div class="form-group">
                <label>Address:</label>
                <textarea name="address" rows="3"><?=$student['address']?></textarea>
            </div>
            
            <div class="form-group">
                <label>Degree:</label>
                <input type="text" name="degree" value="<?=$student['degree']?>">
            </div>
            
            <div class="form-group">
                <label>University:</label>
                <input type="text" name="university" value="<?=$student['university']?>">
            </div>
            
            <div class="form-group">
                <label>Graduation Year:</label>
                <input type="number" name="graduation_year" value="<?=$student['graduation_year']?>">
            </div>
            
            <div class="form-group">
                <label>Skills:</label>
                <textarea name="skills" rows="4"><?=$student['skills']?></textarea>
            </div>
            
            <div class="form-group">
                <label>Experience:</label>
                <textarea name="experience" rows="4"><?=$student['experience']?></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
