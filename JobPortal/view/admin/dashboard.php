<?php
session_start();

// Check authentication
if(!isset($_COOKIE['status'])){
    header('location: ../login.php?error=badrequest');
    exit();
}

// Check if admin
if($_SESSION['user_type'] != 'admin'){
    header('location: ../login.php?error=badrequest');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Job Portal</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewAllUsers.php">All Users</a>
        <a href="approveCompany.php">Company Requests</a>
        <a href="approveCounselor.php">Counselor Requests</a>
        <a href="approveJobPost.php">Job Post Requests</a>
        <a href="changePassword.php">Change Password</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <div class="dashboard">
            <div class="dashboard-header">
                <h1>Welcome Admin, <?=$_SESSION['username']?>!</h1>
                <p>Manage and monitor the entire job portal system</p>
            </div>
            
            <div class="dashboard-cards">
                <div class="card">
                    <h3>View All Users</h3>
                    <p>Manage all registered users</p>
                    <a href="viewAllUsers.php" class="btn btn-primary">View Users</a>
                </div>
                
                <div class="card">
                    <h3>Company Requests</h3>
                    <p>Approve or reject company accounts</p>
                    <a href="approveCompany.php" class="btn btn-primary">Manage</a>
                </div>
                
                <div class="card">
                    <h3>Counselor Requests</h3>
                    <p>Approve or reject counselor accounts</p>
                    <a href="approveCounselor.php" class="btn btn-primary">Manage</a>
                </div>
                
                <div class="card">
                    <h3>Job Post Requests</h3>
                    <p>Approve or reject job posts</p>
                    <a href="approveJobPost.php" class="btn btn-primary">Manage</a>
                </div>
                
                <div class="card">
                    <h3>Block Users</h3>
                    <p>Block suspicious accounts</p>
                    <a href="blockUser.php" class="btn btn-danger">Block Users</a>
                </div>
                
                <div class="card">
                    <h3>Fraud Management</h3>
                    <p>Mark fraudulent accounts</p>
                    <a href="markFraud.php" class="btn btn-danger">Manage Fraud</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
