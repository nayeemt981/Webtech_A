<?php
session_start();
require_once('../../model/adminModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'admin'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$jobs = getPendingJobPosts();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Post Requests - Admin</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="approveJobPost.php">Job Post Requests</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Pending Job Post Approval Requests</h2>
        
        <?php if(count($jobs) == 0): ?>
        <div class="alert alert-info">No pending job post requests.</div>
        <?php else: ?>
        <table>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Category</th>
                <th>Type</th>
                <th>Location</th>
                <th>Posted Date</th>
                <th>Action</th>
            </tr>
            <?php foreach($jobs as $job): ?>
            <tr>
                <td><?=$job['job_title']?></td>
                <td><?=$job['company_name']?></td>
                <td><?=$job['job_category']?></td>
                <td><?=$job['job_type']?></td>
                <td><?=$job['location']?></td>
                <td><?=date('M d, Y', strtotime($job['created_at']))?></td>
                <td>
                    <button onclick="approveJobPost(<?=$job['id']?>)" class="btn btn-primary">Approve</button>
                    <button onclick="rejectJobPost(<?=$job['id']?>)" class="btn btn-danger">Reject</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    
    <script>
    function approveJobPost(jobId){
        let data = JSON.stringify({'job_id': jobId, 'status': 'approved'});
        
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../../controller/updateJobStatusController.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + data);
        
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                let response = JSON.parse(this.responseText);
                if(response.success){
                    alert(response.message);
                    location.reload();
                }
            }
        }
    }
    
    function rejectJobPost(jobId){
        let data = JSON.stringify({'job_id': jobId, 'status': 'rejected'});
        
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../../controller/updateJobStatusController.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + data);
        
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                let response = JSON.parse(this.responseText);
                if(response.success){
                    alert(response.message);
                    location.reload();
                }
            }
        }
    }
    </script>
</body>
</html>
