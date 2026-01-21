<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration - Job Portal</title>
    <link rel="stylesheet" href="../asset/css/style.css">
    <script src="../asset/js/validation.js"></script>
    <script src="../asset/js/ajax.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Create Your Account</h2>
            
            <?php
            if(isset($_REQUEST['error'])){
                if($_REQUEST['error'] == "null"){
                    echo "<div class='alert alert-error'>Please fill all required fields!</div>";
                } elseif($_REQUEST['error'] == "invalid_email"){
                    echo "<div class='alert alert-error'>Invalid email format!</div>";
                } elseif($_REQUEST['error'] == "password_mismatch"){
                    echo "<div class='alert alert-error'>Passwords do not match!</div>";
                } elseif($_REQUEST['error'] == "username_exists"){
                    echo "<div class='alert alert-error'>Username already exists!</div>";
                } elseif($_REQUEST['error'] == "email_exists"){
                    echo "<div class='alert alert-error'>Email already exists!</div>";
                } elseif($_REQUEST['error'] == "failed"){
                    echo "<div class='alert alert-error'>Registration failed! Try again.</div>";
                }
            }
            ?>
            
            <form method="post" action="../controller/registrationController.php" onsubmit="return validateRegistration()">
                <div class="form-group">
                    <label>User Type: <span style="color:red;">*</span></label>
                    <select name="user_type" id="user_type" onchange="showUserTypeFields()">
                        <option value="">Select Type</option>
                        <option value="student">Student (Job Seeker)</option>
                        <option value="company">Company (Recruiter)</option>
                        <option value="counselor">Career Counselor</option>
                    </select>
                    <p class="error-msg" id="userTypeError"></p>
                </div>
                
                <div class="form-group">
                    <label>Username: <span style="color:red;">*</span></label>
                    <input type="text" name="username" id="username" onblur="checkUsernameAvailability()">
                    <p class="error-msg" id="usernameError"></p>
                    <p class="success-msg" id="usernameSuccess"></p>
                </div>
                
                <div class="form-group">
                    <label>Email: <span style="color:red;">*</span></label>
                    <input type="text" name="email" id="email" onblur="checkEmailAvailability()">
                    <p class="error-msg" id="emailError"></p>
                    <p class="success-msg" id="emailSuccess"></p>
                </div>
                
                <div class="form-group">
                    <label>Password: <span style="color:red;">*</span></label>
                    <input type="password" name="password" id="password" onblur="checkPasswordReg()">
                    <p class="error-msg" id="passwordError"></p>
                </div>
                
                <div class="form-group">
                    <label>Confirm Password: <span style="color:red;">*</span></label>
                    <input type="password" name="confirm_password" id="confirm_password" onblur="checkConfirmPassword()">
                    <p class="error-msg" id="confirmPasswordError"></p>
                </div>
                
                <!-- Student Fields -->
                <div id="student_fields" style="display:none;">
                    <div class="form-group">
                        <label>Full Name: <span style="color:red;">*</span></label>
                        <input type="text" name="student_full_name" id="full_name">
                    </div>
                    <div class="form-group">
                        <label>Phone: <span style="color:red;">*</span></label>
                        <input type="text" name="student_phone" id="phone">
                    </div>
                </div>
                
                <!-- Company Fields -->
                <div id="company_fields" style="display:none;">
                    <div class="form-group">
                        <label>Company Name: <span style="color:red;">*</span></label>
                        <input type="text" name="company_name" id="company_name">
                    </div>
                    <div class="form-group">
                        <label>Location: <span style="color:red;">*</span></label>
                        <input type="text" name="location" id="location">
                    </div>
                </div>
                
                <!-- Counselor Fields -->
                <div id="counselor_fields" style="display:none;">
                    <div class="form-group">
                        <label>Full Name: <span style="color:red;">*</span></label>
                        <input type="text" name="counselor_full_name" id="counselor_full_name">
                    </div>
                    <div class="form-group">
                        <label>Specialization: <span style="color:red;">*</span></label>
                        <input type="text" name="counselor_specialization" id="specialization">
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                
                <div class="form-group">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
