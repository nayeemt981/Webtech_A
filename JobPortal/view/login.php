<?php
session_start();
$remember_user = isset($_COOKIE['remember_user']) ? $_COOKIE['remember_user'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Job Portal</title>
    <link rel="stylesheet" href="../asset/css/style.css">
    <script src="../asset/js/validation.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Login to Your Account</h2>
            
            <?php
            if(isset($_REQUEST['error'])){
                if($_REQUEST['error'] == "null"){
                    echo "<div class='alert alert-error'>Please fill all fields!</div>";
                } elseif($_REQUEST['error'] == "invalid"){
                    echo "<div class='alert alert-error'>Invalid username or password!</div>";
                } elseif($_REQUEST['error'] == "blocked"){
                    echo "<div class='alert alert-error'>Your account has been blocked!</div>";
                } elseif($_REQUEST['error'] == "pending"){
                    echo "<div class='alert alert-error'>Your account is pending approval!</div>";
                } elseif($_REQUEST['error'] == "rejected"){
                    echo "<div class='alert alert-error'>Your account has been rejected!</div>";
                } elseif($_REQUEST['error'] == "badrequest"){
                    echo "<div class='alert alert-error'>Please login first!</div>";
                }
            }
            
            if(isset($_REQUEST['success'])){
                if($_REQUEST['success'] == "registered"){
                    echo "<div class='alert alert-success'>Registration successful! Please login.</div>";
                } elseif($_REQUEST['success'] == "pending_approval"){
                    echo "<div class='alert alert-info'>Registration successful! Wait for admin approval.</div>";
                } elseif($_REQUEST['success'] == "logout"){
                    echo "<div class='alert alert-success'>Logged out successfully!</div>";
                } elseif($_REQUEST['success'] == "password_changed"){
                    echo "<div class='alert alert-success'>Password changed successfully!</div>";
                }
            }
            ?>
            
            <form method="post" action="../controller/loginController.php" onsubmit="return validateLogin()">
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" id="username" value="<?=$remember_user?>" onblur="checkUsername()">
                    <p class="error-msg" id="usernameError"></p>
                </div>
                
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" id="password" onblur="checkPassword()">
                    <p class="error-msg" id="passwordError"></p>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember" value="yes" <?php if($remember_user != ""){ echo "checked"; } ?>>
                        Remember Me
                    </label>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                
                <div class="form-group">
                    <p>Don't have an account? <a href="registration.php">Register here</a></p>
                    <p><a href="resetPassword.php">Forgot Password?</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
