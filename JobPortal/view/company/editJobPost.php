<?php
session_start();
require_once('../../model/companyModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'company'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$job_id = $_REQUEST['id'];
$job = getJobById($job_id);

if(!$job){
    header('location: viewJobPostList.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Job Post - Company</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/validation.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Company</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewJobPostList.php">My Jobs</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <div class="form-container">
            <h2>Edit Job Post</h2>
            
            <?php
            if(isset($_REQUEST['success'])){
                echo "<div class='alert alert-success'>Job post updated successfully!</div>";
            }
            if(isset($_REQUEST['error'])){
                echo "<div class='alert alert-error'>Failed to update job post!</div>";
            }
            ?>
            
            <form method="post" action="../../controller/updateJobPostController.php" onsubmit="return validateJobPost()">
                <input type="hidden" name="job_id" value="<?=$job['id']?>">
                
                <div class="form-group">
                    <label>Job Title: <span style="color:red;">*</span></label>
                    <input type="text" name="job_title" id="job_title" value="<?=$job['job_title']?>" required>
                </div>
                
                <div class="form-group">
                    <label>Job Category: <span style="color:red;">*</span></label>
                    <select name="job_category" id="job_category" required>
                        <option value="">Select Category</option>
                        <option value="IT" <?=$job['job_category']=='IT'?'selected':''?>>IT</option>
                        <option value="Engineering" <?=$job['job_category']=='Engineering'?'selected':''?>>Engineering</option>
                        <option value="Marketing" <?=$job['job_category']=='Marketing'?'selected':''?>>Marketing</option>
                        <option value="Finance" <?=$job['job_category']=='Finance'?'selected':''?>>Finance</option>
                        <option value="Healthcare" <?=$job['job_category']=='Healthcare'?'selected':''?>>Healthcare</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Job Type: <span style="color:red;">*</span></label>
                    <select name="job_type" id="job_type" required>
                        <option value="">Select Type</option>
                        <option value="full-time" <?=$job['job_type']=='full-time'?'selected':''?>>Full Time</option>
                        <option value="part-time" <?=$job['job_type']=='part-time'?'selected':''?>>Part Time</option>
                        <option value="internship" <?=$job['job_type']=='internship'?'selected':''?>>Internship</option>
                        <option value="contract" <?=$job['job_type']=='contract'?'selected':''?>>Contract</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Salary Range:</label>
                    <input type="text" name="salary_range" value="<?=$job['salary_range']?>">
                </div>
                
                <div class="form-group">
                    <label>Location: <span style="color:red;">*</span></label>
                    <input type="text" name="location" id="location" value="<?=$job['location']?>" required>
                </div>
                
                <div class="form-group">
                    <label>Job Description: <span style="color:red;">*</span></label>
                    <textarea name="description" id="description" rows="6" required><?=$job['description']?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Requirements:</label>
                    <textarea name="requirements" rows="6"><?=$job['requirements']?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Application Deadline:</label>
                    <input type="date" name="deadline" value="<?=$job['deadline']?>">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Job Post</button>
                    <a href="viewJobPostList.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
