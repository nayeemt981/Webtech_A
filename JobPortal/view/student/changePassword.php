<?php
session_start();

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'student'){
    header('location: ../login.php?error=badrequest');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password - Student</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/validation.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Student</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <div class="form-container">
            <h2>Change Password</h2>
            
            <?php
            if(isset($_REQUEST['error'])){
                if($_REQUEST['error'] == "null"){
                    echo "<div class='alert alert-error'>Please fill all fields!</div>";
                } elseif($_REQUEST['error'] == "mismatch"){
                    echo "<div class='alert alert-error'>New passwords do not match!</div>";
                } elseif($_REQUEST['error'] == "short"){
                    echo "<div class='alert alert-error'>Password must be at least 6 characters!</div>";
                } elseif($_REQUEST['error'] == "wrong_password"){
                    echo "<div class='alert alert-error'>Old password is incorrect!</div>";
                }
            }
            
            if(isset($_REQUEST['success']) && $_REQUEST['success'] == "changed"){
                echo "<div class='alert alert-success'>Password changed successfully!</div>";
            }
            ?>
            
            <form method="post" action="../../controller/changePasswordController.php" onsubmit="return validateChangePassword()">
                <div class="form-group">
                    <label>Old Password:</label>
                    <input type="password" name="old_password" id="old_password">
                </div>
                
                <div class="form-group">
                    <label>New Password:</label>
                    <input type="password" name="new_password" id="new_password">
                </div>
                
                <div class="form-group">
                    <label>Confirm New Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
