<?php
session_start();
require_once('../../model/companyModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'company'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$jobs = getCompanyJobs($_SESSION['profile_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Job Posts - Company</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
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
        <h2>My Job Posts</h2>
        
        <?php if(count($jobs) == 0): ?>
        <div class="alert alert-info">
            No job posts yet. <a href="createJobPost.php">Create your first job post</a>
        </div>
        <?php else: ?>
        <table>
            <tr>
                <th>Job Title</th>
                <th>Category</th>
                <th>Type</th>
                <th>Posted Date</th>
                <th>Status</th>
                <th>Views</th>
                <th>Action</th>
            </tr>
            <?php foreach($jobs as $job): ?>
            <tr>
                <td><?=$job['job_title']?></td>
                <td><?=$job['job_category']?></td>
                <td><?=$job['job_type']?></td>
                <td><?=date('M d, Y', strtotime($job['created_at']))?></td>
                <td>
                    <?php
                    if($job['status'] == 'pending'){
                        echo "<span class='status status-pending'>Pending</span>";
                    } elseif($job['status'] == 'approved'){
                        echo "<span class='status status-approved'>Approved</span>";
                    } elseif($job['status'] == 'rejected'){
                        echo "<span class='status status-rejected'>Rejected</span>";
                    }
                    ?>
                </td>
                <td><?=$job['views']?></td>
                <td>
                    <a href="editJobPost.php?id=<?=$job['id']?>">Edit</a> |
                    <a href="../../controller/deleteJobPostController.php?id=<?=$job['id']?>" onclick="return confirm('Delete this job post?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
