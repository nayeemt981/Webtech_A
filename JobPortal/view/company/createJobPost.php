<?php
session_start();
require_once('../../model/companyModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'company'){
    header('location: ../login.php?error=badrequest');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Job Post - Company</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/validation.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Company</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewJobPostList.php">My Jobs</a>
        <a href="createJobPost.php">Create Job</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <div class="form-container">
            <h2>Create New Job Post</h2>
            
            <?php
            if(isset($_REQUEST['success'])){
                echo "<div class='alert alert-success'>Job post created! Waiting for admin approval.</div>";
            }
            if(isset($_REQUEST['error'])){
                echo "<div class='alert alert-error'>Failed to create job post!</div>";
            }
            ?>
            
            <form method="post" action="../../controller/createJobPostController.php" onsubmit="return validateJobPost()">
                <div class="form-group">
                    <label>Job Title: <span style="color:red;">*</span></label>
                    <input type="text" name="job_title" id="job_title" required>
                </div>
                
                <div class="form-group">
                    <label>Job Category: <span style="color:red;">*</span></label>
                    <select name="job_category" id="job_category" required>
                        <option value="">Select Category</option>
                        <option value="IT">IT</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Finance">Finance</option>
                        <option value="Healthcare">Healthcare</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Job Type: <span style="color:red;">*</span></label>
                    <select name="job_type" id="job_type" required>
                        <option value="">Select Type</option>
                        <option value="full-time">Full Time</option>
                        <option value="part-time">Part Time</option>
                        <option value="internship">Internship</option>
                        <option value="contract">Contract</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Salary Range:</label>
                    <input type="text" name="salary_range" placeholder="e.g., 30,000 - 50,000 BDT">
                </div>
                
                <div class="form-group">
                    <label>Location: <span style="color:red;">*</span></label>
                    <input type="text" name="location" id="location" required>
                </div>
                
                <div class="form-group">
                    <label>Job Description: <span style="color:red;">*</span></label>
                    <textarea name="description" id="description" rows="6" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Requirements:</label>
                    <textarea name="requirements" rows="6"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Application Deadline:</label>
                    <input type="date" name="deadline">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Job Post</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
