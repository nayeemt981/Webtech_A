// Check Username Availability (Ajax)
function checkUsernameAvailability(){
    let username = document.getElementById('username').value;
    let usernameError = document.getElementById('usernameError');
    let usernameSuccess = document.getElementById('usernameSuccess');
    
    if(username == ""){
        usernameError.innerHTML = "Username is required!";
        usernameSuccess.innerHTML = "";
        return;
    }
    
    let data = JSON.stringify({'username': username});
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controller/checkUsernameController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + data);
    
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let response = JSON.parse(this.responseText);
            if(response.exists){
                usernameError.innerHTML = "Username already exists!";
                usernameSuccess.innerHTML = "";
            } else {
                usernameError.innerHTML = "";
                usernameSuccess.innerHTML = "Username available!";
            }
        }
    }
}

// Check Email Availability (Ajax)
function checkEmailAvailability(){
    let email = document.getElementById('email').value;
    let emailError = document.getElementById('emailError');
    let emailSuccess = document.getElementById('emailSuccess');
    
    if(email == ""){
        emailError.innerHTML = "Email is required!";
        emailSuccess.innerHTML = "";
        return;
    }
    
    if(email.indexOf('@') == -1 || email.indexOf('.') == -1){
        emailError.innerHTML = "Invalid email format!";
        emailSuccess.innerHTML = "";
        return;
    }
    
    let data = JSON.stringify({'email': email});
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controller/checkEmailController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + data);
    
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let response = JSON.parse(this.responseText);
            if(response.exists){
                emailError.innerHTML = "Email already exists!";
                emailSuccess.innerHTML = "";
            } else {
                emailError.innerHTML = "";
                emailSuccess.innerHTML = "Email available!";
            }
        }
    }
}

// Search Jobs (Ajax)
function searchJobs(){
    let keyword = document.getElementById('keyword').value;
    let category = document.getElementById('category').value;
    
    let data = JSON.stringify({'keyword': keyword, 'category': category});
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controller/searchJobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + data);
    
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            document.getElementById('job_results').innerHTML = this.responseText;
        }
    }
}

// Shortlist Job (Ajax)
function shortlistJob(jobId){
    console.log('Shortlist button clicked for job:', jobId);
    
    let data = JSON.stringify({'job_id': jobId});
    console.log('Sending data:', data);
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controller/shortlistJobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xhttp.onreadystatechange = function(){
        console.log('Shortlist ReadyState:', this.readyState, 'Status:', this.status);
        if(this.readyState == 4 && this.status == 200){
            console.log('Shortlist Response:', this.responseText);
            let response = JSON.parse(this.responseText);
            if(response.success){
                alert(response.message);
                location.reload();
            } else {
                alert(response.message);
            }
        }
    }
    
    xhttp.send("data=" + data);
    console.log('Shortlist request sent');
}

// Apply for Job (Ajax)
function applyJob(jobId){
    console.log('Apply button clicked for job:', jobId);
    
    if(!confirm('Are you sure you want to apply for this job?')){
        return;
    }
    
    console.log('User confirmed, sending application...');
    
    let data = JSON.stringify({'job_id': jobId, 'cover_letter': ''});
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controller/applyJobController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xhttp.onreadystatechange = function(){
        console.log('ReadyState:', this.readyState, 'Status:', this.status);
        if(this.readyState == 4 && this.status == 200){
            console.log('Response:', this.responseText);
            let response = JSON.parse(this.responseText);
            if(response.success){
                alert(response.message);
                location.reload();
            } else {
                alert(response.message);
            }
        }
    }
    
    xhttp.send("data=" + data);
    console.log('Request sent');
}

// Shortlist Candidate (Ajax)
function shortlistCandidate(applicationId){
    let data = JSON.stringify({'application_id': applicationId});
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controller/shortlistCandidateController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + data);
    
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let response = JSON.parse(this.responseText);
            if(response.success){
                alert(response.message);
                location.reload();
            }
        }
    }
}

// Update Interview Result (Ajax)
function updateInterviewResult(interviewId, result){
    let data = JSON.stringify({'interview_id': interviewId, 'result': result});
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controller/updateInterviewResultController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + data);
    
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let response = JSON.parse(this.responseText);
            if(response.success){
                alert(response.message);
                location.reload();
            }
        }
    }
}

// Approve/Reject User (Ajax)
function updateUserStatus(userId, status){
    let data = JSON.stringify({'user_id': userId, 'status': status});
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controller/updateUserStatusController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + data);
    
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let response = JSON.parse(this.responseText);
            if(response.success){
                alert(response.message);
                location.reload();
            }
        }
    }
}

// Block User (Ajax)
function blockUser(userId){
    if(confirm('Are you sure you want to block this user?')){
        updateUserStatus(userId, 'blocked');
    }
}

// Mark as Fraud (Ajax)
function markFraud(userId){
    if(confirm('Are you sure you want to mark this user as fraud?')){
        let data = JSON.stringify({'user_id': userId});
        
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../../controller/markFraudController.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + data);
        
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                let response = JSON.parse(this.responseText);
                if(response.success){
                    alert(response.message);
                    location.reload();
                }
            }
        }
    }
}

// Load Application Status (Ajax)
function loadApplicationStatus(){
    let xhttp = new XMLHttpRequest();
    xhttp.open('GET', '../../controller/getApplicationStatusController.php', true);
    xhttp.send();
    
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            document.getElementById('application_status_table').innerHTML = this.responseText;
        }
    }
}

// Calculate Profile Completion
function calculateProfileCompletion(){
    let xhttp = new XMLHttpRequest();
    xhttp.open('GET', '../../controller/getProfileCompletionController.php', true);
    xhttp.send();
    
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let response = JSON.parse(this.responseText);
            document.getElementById('completion_percentage').innerHTML = response.percentage + '%';
            document.getElementById('progress_fill').style.width = response.percentage + '%';
        }
    }
}
