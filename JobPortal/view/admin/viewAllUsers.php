<?php
session_start();
require_once('../../model/adminModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'admin'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$users = getAllUsers();
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Users - Admin</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewAllUsers.php">All Users</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>All Users</h2>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Name/Company</th>
                <th>User Type</th>
                <th>Status</th>
                <th>Fraud</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['email']?></td>
                <td><?=$user['display_name']?></td>
                <td><?=$user['user_type']?></td>
                <td>
                    <?php
                    if($user['status'] == 'pending'){
                        echo "<span class='status status-pending'>Pending</span>";
                    } elseif($user['status'] == 'approved'){
                        echo "<span class='status status-approved'>Approved</span>";
                    } elseif($user['status'] == 'rejected'){
                        echo "<span class='status status-rejected'>Rejected</span>";
                    } elseif($user['status'] == 'blocked'){
                        echo "<span class='status status-blocked'>Blocked</span>";
                    }
                    ?>
                </td>
                <td><?=$user['is_fraud'] == 1 ? 'Yes' : 'No'?></td>
                <td><?=date('M d, Y', strtotime($user['created_at']))?></td>
                <td>
                    <?php if($user['status'] == 'pending'): ?>
                    <button onclick="updateUserStatus(<?=$user['id']?>, 'approved')" class="btn btn-primary">Approve</button>
                    <button onclick="updateUserStatus(<?=$user['id']?>, 'rejected')" class="btn btn-danger">Reject</button>
                    <?php elseif($user['status'] != 'blocked'): ?>
                    <button onclick="blockUser(<?=$user['id']?>)" class="btn btn-danger">Block</button>
                    <?php endif; ?>
                    <?php if($user['is_fraud'] == 0): ?>
                    <button onclick="markFraud(<?=$user['id']?>)" class="btn btn-danger">Mark Fraud</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
