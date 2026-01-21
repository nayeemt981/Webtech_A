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
    <title>Edit Resume - Student</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Student</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="editResume.php">Resume</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <div class="form-container">
            <h2>Upload/Update Resume</h2>
            
            <?php
            if(isset($_REQUEST['success'])){
                echo "<div class='alert alert-success'>Resume uploaded successfully!</div>";
            }
            if(isset($_REQUEST['error'])){
                if($_REQUEST['error'] == "no_file"){
                    echo "<div class='alert alert-error'>Please select a file!</div>";
                } elseif($_REQUEST['error'] == "invalid_type"){
                    echo "<div class='alert alert-error'>Only PDF, DOC, DOCX files allowed!</div>";
                } elseif($_REQUEST['error'] == "large_file"){
                    echo "<div class='alert alert-error'>File size must be less than 5MB!</div>";
                } elseif($_REQUEST['error'] == "upload_failed"){
                    echo "<div class='alert alert-error'>Upload failed! Try again.</div>";
                }
            }
            ?>
            
            <?php if($student['resume_file'] != ""): ?>
            <div class="alert alert-info">
                Current Resume: <strong><?=$student['resume_file']?></strong><br>
                <a href="../../asset/uploads/resumes/<?=$student['resume_file']?>" target="_blank">Download Resume</a>
            </div>
            <?php endif; ?>
            
            <form method="post" action="../../controller/uploadResumeController.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Select Resume (PDF, DOC, DOCX - Max 5MB):</label>
                    <input type="file" name="resume_file" accept=".pdf,.doc,.docx" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Upload Resume</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
