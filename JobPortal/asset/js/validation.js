// Login Form Validation
function checkUsername(){
    let username = document.getElementById('username').value;
    let usernameError = document.getElementById('usernameError');
    
    if(username == ""){
        usernameError.innerHTML = "Username is required!";
        return false;
    } else {
        usernameError.innerHTML = "";
        return true;
    }
}

function checkPassword(){
    let password = document.getElementById('password').value;
    let passwordError = document.getElementById('passwordError');
    
    if(password == ""){
        passwordError.innerHTML = "Password is required!";
        return false;
    } else {
        passwordError.innerHTML = "";
        return true;
    }
}

function validateLogin(){
    let usernameValid = checkUsername();
    let passwordValid = checkPassword();
    
    if(usernameValid && passwordValid){
        return true;
    }
    return false;
}

// Registration Form Validation
function showUserTypeFields(){
    let userType = document.getElementById('user_type').value;
    
    document.getElementById('student_fields').style.display = 'none';
    document.getElementById('company_fields').style.display = 'none';
    document.getElementById('counselor_fields').style.display = 'none';
    
    if(userType == 'student'){
        document.getElementById('student_fields').style.display = 'block';
    } else if(userType == 'company'){
        document.getElementById('company_fields').style.display = 'block';
    } else if(userType == 'counselor'){
        document.getElementById('counselor_fields').style.display = 'block';
    }
}

function checkPasswordReg(){
    let password = document.getElementById('password').value;
    let passwordError = document.getElementById('passwordError');
    
    if(password == ""){
        passwordError.innerHTML = "Password is required!";
        return false;
    } else if(password.length < 6){
        passwordError.innerHTML = "Password must be at least 6 characters!";
        return false;
    } else {
        passwordError.innerHTML = "";
        return true;
    }
}

function checkConfirmPassword(){
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirm_password').value;
    let confirmPasswordError = document.getElementById('confirmPasswordError');
    
    if(confirmPassword == ""){
        confirmPasswordError.innerHTML = "Please confirm password!";
        return false;
    } else if(password != confirmPassword){
        confirmPasswordError.innerHTML = "Passwords do not match!";
        return false;
    } else {
        confirmPasswordError.innerHTML = "";
        return true;
    }
}

function validateRegistration(){
    let userType = document.getElementById('user_type').value;
    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirm_password').value;
    
    if(userType == ""){
        alert("Please select user type!");
        return false;
    }
    
    if(username == "" || email == "" || password == "" || confirmPassword == ""){
        alert("Please fill all required fields!");
        return false;
    }
    
    if(email.indexOf('@') == -1 || email.indexOf('.') == -1){
        alert("Invalid email format!");
        return false;
    }
    
    if(password.length < 6){
        alert("Password must be at least 6 characters!");
        return false;
    }
    
    if(password != confirmPassword){
        alert("Passwords do not match!");
        return false;
    }
    
    // Check user type specific fields
    if(userType == 'student'){
        let fullName = document.getElementById('full_name').value;
        let phone = document.getElementById('phone').value;
        if(fullName == "" || phone == ""){
            alert("Please fill all student fields!");
            return false;
        }
    } else if(userType == 'company'){
        let companyName = document.getElementById('company_name').value;
        let location = document.getElementById('location').value;
        if(companyName == "" || location == ""){
            alert("Please fill all company fields!");
            return false;
        }
    } else if(userType == 'counselor'){
        let fullName = document.getElementById('counselor_full_name').value;
        let specialization = document.getElementById('specialization').value;
        if(fullName == "" || specialization == ""){
            alert("Please fill all counselor fields!");
            return false;
        }
    }
    
    return true;
}

// Change Password Validation
function validateChangePassword(){
    let oldPassword = document.getElementById('old_password').value;
    let newPassword = document.getElementById('new_password').value;
    let confirmPassword = document.getElementById('confirm_password').value;
    
    if(oldPassword == "" || newPassword == "" || confirmPassword == ""){
        alert("Please fill all fields!");
        return false;
    }
    
    if(newPassword.length < 6){
        alert("New password must be at least 6 characters!");
        return false;
    }
    
    if(newPassword != confirmPassword){
        alert("New passwords do not match!");
        return false;
    }
    
    return true;
}

// Job Search Validation
function validateJobSearch(){
    let keyword = document.getElementById('keyword').value;
    
    if(keyword == ""){
        alert("Please enter search keyword!");
        return false;
    }
    return true;
}

// Job Post Validation
function validateJobPost(){
    let jobTitle = document.getElementById('job_title').value;
    let jobCategory = document.getElementById('job_category').value;
    let jobType = document.getElementById('job_type').value;
    let location = document.getElementById('location').value;
    let description = document.getElementById('description').value;
    
    if(jobTitle == "" || jobCategory == "" || jobType == "" || location == "" || description == ""){
        alert("Please fill all required fields!");
        return false;
    }
    return true;
}

// Consultation Form Validation
function validateConsultation(){
    let appointmentDate = document.getElementById('appointment_date').value;
    let appointmentTime = document.getElementById('appointment_time').value;
    let notes = document.getElementById('notes').value;
    
    if(appointmentDate == "" || appointmentTime == ""){
        alert("Please select date and time!");
        return false;
    }
    return true;
}

// Interview Schedule Validation
function validateInterview(){
    let interviewDate = document.getElementById('interview_date').value;
    let interviewTime = document.getElementById('interview_time').value;
    let interviewMode = document.getElementById('interview_mode').value;
    
    if(interviewDate == "" || interviewTime == "" || interviewMode == ""){
        alert("Please fill all required fields!");
        return false;
    }
    return true;
}
