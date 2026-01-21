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
    <title>Block Users - Admin</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewAllUsers.php">All Users</a>
        <a href="blockUser.php">Block Users</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Block Suspicious User Accounts</h2>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Current Status</th>
                <th>Fraud</th>
                <th>Action</th>
            </tr>
            <?php foreach($users as $user): ?>
            <?php if($user['status'] != 'blocked' && $user['user_type'] != 'admin'): ?>
            <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['email']?></td>
                <td><?=$user['user_type']?></td>
                <td>
                    <?php
                    if($user['status'] == 'pending'){
                        echo "<span class='status status-pending'>Pending</span>";
                    } elseif($user['status'] == 'approved'){
                        echo "<span class='status status-approved'>Approved</span>";
                    } elseif($user['status'] == 'rejected'){
                        echo "<span class='status status-rejected'>Rejected</span>";
                    }
                    ?>
                </td>
                <td><?=$user['is_fraud'] == 1 ? '<span style="color:red;">Yes</span>' : 'No'?></td>
                <td>
                    <button onclick="blockUser(<?=$user['id']?>)" class="btn btn-danger">Block User</button>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </table>
        
        <h2 style="margin-top: 40px;">Currently Blocked Users</h2>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php 
            $hasBlocked = false;
            foreach($users as $user): 
                if($user['status'] == 'blocked'):
                    $hasBlocked = true;
            ?>
            <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['email']?></td>
                <td><?=$user['user_type']?></td>
                <td><span class='status status-blocked'>Blocked</span></td>
                <td>
                    <button onclick="updateUserStatus(<?=$user['id']?>, 'approved')" class="btn btn-primary">Unblock</button>
                </td>
            </tr>
            <?php 
                endif;
            endforeach; 
            if(!$hasBlocked):
            ?>
            <tr>
                <td colspan="6" style="text-align:center;">No blocked users</td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
