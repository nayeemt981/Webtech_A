<?php
session_start();
require_once('../../model/adminModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'admin'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$companies = getPendingCompanies();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Company Requests - Admin</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="approveCompany.php">Company Requests</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Pending Company Registration Requests</h2>
        
        <?php if(count($companies) == 0): ?>
        <div class="alert alert-info">No pending company requests.</div>
        <?php else: ?>
        <table>
            <tr>
                <th>Company Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Industry</th>
                <th>Location</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
            <?php foreach($companies as $company): ?>
            <tr>
                <td><?=$company['company_name']?></td>
                <td><?=$company['username']?></td>
                <td><?=$company['email']?></td>
                <td><?=$company['industry']?></td>
                <td><?=$company['location']?></td>
                <td><?=date('M d, Y', strtotime($company['created_at']))?></td>
                <td>
                    <button onclick="updateUserStatus(<?=$company['user_id']?>, 'approved')" class="btn btn-primary">Approve</button>
                    <button onclick="updateUserStatus(<?=$company['user_id']?>, 'rejected')" class="btn btn-danger">Reject</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
