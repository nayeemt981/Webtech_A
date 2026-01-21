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
    <title>Fraud Management - Admin</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewAllUsers.php">All Users</a>
        <a href="markFraud.php">Fraud Management</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Mark Fraudulent User Accounts</h2>
        
        <div class="alert alert-error">
            <strong>Warning:</strong> Marking a user as fraud will automatically block their account!
        </div>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Name/Company</th>
                <th>User Type</th>
                <th>Status</th>
                <th>Fraud Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($users as $user): ?>
            <?php if($user['is_fraud'] == 0 && $user['user_type'] != 'admin'): ?>
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
                <td>Not Marked</td>
                <td>
                    <button onclick="markFraud(<?=$user['id']?>)" class="btn btn-danger">Mark as Fraud</button>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </table>
        
        <h2 style="margin-top: 40px;">Users Marked as Fraud</h2>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Name/Company</th>
                <th>User Type</th>
                <th>Status</th>
                <th>Fraud</th>
            </tr>
            <?php 
            $hasFraud = false;
            foreach($users as $user): 
                if($user['is_fraud'] == 1):
                    $hasFraud = true;
            ?>
            <tr style="background-color: #ffcccc;">
                <td><?=$user['id']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['email']?></td>
                <td><?=$user['display_name']?></td>
                <td><?=$user['user_type']?></td>
                <td><span class='status status-blocked'>Blocked</span></td>
                <td><strong style="color:red;">FRAUD</strong></td>
            </tr>
            <?php 
                endif;
            endforeach; 
            if(!$hasFraud):
            ?>
            <tr>
                <td colspan="7" style="text-align:center;">No fraud users</td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
