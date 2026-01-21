<?php
session_start();
require_once('../../model/adminModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'admin'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$counselors = getPendingCounselors();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Counselor Requests - Admin</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="approveCounselor.php">Counselor Requests</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Pending Counselor Registration Requests</h2>
        
        <?php if(count($counselors) == 0): ?>
        <div class="alert alert-info">No pending counselor requests.</div>
        <?php else: ?>
        <table>
            <tr>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>Experience</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
            <?php foreach($counselors as $counselor): ?>
            <tr>
                <td><?=$counselor['full_name']?></td>
                <td><?=$counselor['username']?></td>
                <td><?=$counselor['email']?></td>
                <td><?=$counselor['specialization']?></td>
                <td><?=$counselor['experience_years']?> years</td>
                <td><?=date('M d, Y', strtotime($counselor['created_at']))?></td>
                <td>
                    <button onclick="updateUserStatus(<?=$counselor['user_id']?>, 'approved')" class="btn btn-primary">Approve</button>
                    <button onclick="updateUserStatus(<?=$counselor['user_id']?>, 'rejected')" class="btn btn-danger">Reject</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
