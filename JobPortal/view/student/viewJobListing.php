<?php
session_start();
require_once('../../model/jobModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'student'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$jobs = getAllApprovedJobs();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Listings - Student</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Student</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewJobListing.php">View Jobs</a>
        <a href="shortlistedJobs.php">Shortlisted</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Available Job Opportunities</h2>
        
        <div class="search-box">
            <input type="text" id="keyword" placeholder="Search by job title or keyword...">
            <select id="category">
                <option value="">All Categories</option>
                <option value="IT">IT</option>
                <option value="Engineering">Engineering</option>
                <option value="Marketing">Marketing</option>
                <option value="Finance">Finance</option>
                <option value="Healthcare">Healthcare</option>
            </select>
            <button onclick="searchJobs()" class="btn btn-primary">Search</button>
        </div>
        
        <div id="job_results">
            <?php if(count($jobs) == 0): ?>
                <div class="alert alert-info">No jobs available at the moment. Please check back later.</div>
            <?php else: ?>
            <?php foreach($jobs as $job): ?>
            <div class="job-card">
                <h3><?=$job['job_title']?></h3>
                <p class="company-name"><?=$job['company_name']?></p>
                
                <div class="job-details">
                    <p><strong>Category:</strong> <?=$job['job_category']?></p>
                    <p><strong>Type:</strong> <?=$job['job_type']?></p>
                    <p><strong>Location:</strong> <?=$job['location']?></p>
                    <p><strong>Salary:</strong> <?=$job['salary_range']?></p>
                    <p><strong>Deadline:</strong> <?=$job['deadline']?></p>
                </div>
                
                <p><?=substr($job['description'], 0, 200)?>...</p>
                
                <div class="button-group">
                    <button onclick="applyJob(<?=$job['id']?>)" class="btn btn-primary">Apply</button>
                    <button onclick="shortlistJob(<?=$job['id']?>)" class="btn btn-secondary">Shortlist</button>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
