<?php
session_start();
require_once('../../model/studentModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'student'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$student = getStudentProfile($_SESSION['profile_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Video Resume - Student</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Student</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <div class="form-container">
            <h2>Upload Video Resume</h2>
            
            <?php
            if(isset($_REQUEST['success'])){
                echo "<div class='alert alert-success'>Video uploaded successfully!</div>";
            }
            if(isset($_REQUEST['error'])){
                if($_REQUEST['error'] == "no_file"){
                    echo "<div class='alert alert-error'>Please select a video file!</div>";
                } elseif($_REQUEST['error'] == "invalid_type"){
                    echo "<div class='alert alert-error'>Only MP4, AVI, MOV files allowed!</div>";
                } elseif($_REQUEST['error'] == "large_file"){
                    echo "<div class='alert alert-error'>File size must be less than 50MB!</div>";
                } elseif($_REQUEST['error'] == "upload_failed"){
                    echo "<div class='alert alert-error'>Upload failed! Try again.</div>";
                }
            }
            ?>
            
            <?php if($student['video_resume'] != ""): ?>
            <div class="alert alert-info">
                Current Video: <strong><?=$student['video_resume']?></strong><br>
                <a href="../../asset/uploads/videos/<?=$student['video_resume']?>" target="_blank">View Video</a>
            </div>
            <?php endif; ?>
            
            <form method="post" action="../../controller/uploadVideoResumeController.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Select Video Resume (MP4, AVI, MOV - Max 50MB):</label>
                    <input type="file" name="video_file" accept="video/*" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Upload Video</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
