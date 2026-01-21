<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - Job Portal</title>
    <link rel="stylesheet" href="../asset/css/style.css">
    <script src="../asset/js/validation.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Reset Your Password</h2>
            
            <?php
            if(isset($_REQUEST['error'])){
                if($_REQUEST['error'] == "null"){
                    echo "<div class='alert alert-error'>Please fill all fields!</div>";
                } elseif($_REQUEST['error'] == "invalid_email"){
                    echo "<div class='alert alert-error'>Invalid email format!</div>";
                } elseif($_REQUEST['error'] == "mismatch"){
                    echo "<div class='alert alert-error'>Passwords do not match!</div>";
                } elseif($_REQUEST['error'] == "short"){
                    echo "<div class='alert alert-error'>Password must be at least 6 characters!</div>";
                } elseif($_REQUEST['error'] == "email_not_found"){
                    echo "<div class='alert alert-error'>Email not found!</div>";
                }
            }
            ?>
            
            <form method="post" action="../controller/resetPasswordController.php" onsubmit="return validateChangePassword()">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" name="email" id="email">
                </div>
                
                <div class="form-group">
                    <label>New Password:</label>
                    <input type="password" name="new_password" id="new_password">
                </div>
                
                <div class="form-group">
                    <label>Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
                
                <div class="form-group">
                    <p><a href="login.php">Back to Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
