<?php
require_once('db.php');

function createJobPost($company_id, $data){
    $con = getConnection();
    
    $job_title = mysqli_real_escape_string($con, $data['job_title']);
    $job_category = mysqli_real_escape_string($con, $data['job_category']);
    $job_type = mysqli_real_escape_string($con, $data['job_type']);
    $salary_range = mysqli_real_escape_string($con, $data['salary_range']);
    $location = mysqli_real_escape_string($con, $data['location']);
    $description = mysqli_real_escape_string($con, $data['description']);
    $requirements = mysqli_real_escape_string($con, $data['requirements']);
    $deadline = mysqli_real_escape_string($con, $data['deadline']);
    
    $sql = "INSERT INTO jobs (company_id, job_title, job_category, job_type, salary_range, location, description, requirements, deadline, status) 
            VALUES ({$company_id}, '{$job_title}', '{$job_category}', '{$job_type}', '{$salary_range}', '{$location}', '{$description}', '{$requirements}', '{$deadline}', 'pending')";
    
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}

function getCompanyJobs($company_id){
    $con = getConnection();
    $sql = "SELECT * FROM jobs WHERE company_id = {$company_id} ORDER BY created_at DESC";
    $result = mysqli_query($con, $sql);
    
    $jobs = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($jobs, $row);
    }
    return $jobs;
}

function getJobById($job_id){
    $con = getConnection();
    $sql = "SELECT * FROM jobs WHERE id = {$job_id}";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function updateJobPost($job_id, $data){
    $con = getConnection();
    
    $job_title = mysqli_real_escape_string($con, $data['job_title']);
    $job_category = mysqli_real_escape_string($con, $data['job_category']);
    $job_type = mysqli_real_escape_string($con, $data['job_type']);
    $salary_range = mysqli_real_escape_string($con, $data['salary_range']);
    $location = mysqli_real_escape_string($con, $data['location']);
    $description = mysqli_real_escape_string($con, $data['description']);
    $requirements = mysqli_real_escape_string($con, $data['requirements']);
    $deadline = mysqli_real_escape_string($con, $data['deadline']);
    
    $sql = "UPDATE jobs SET 
            job_title = '{$job_title}',
            job_category = '{$job_category}',
            job_type = '{$job_type}',
            salary_range = '{$salary_range}',
            location = '{$location}',
            description = '{$description}',
            requirements = '{$requirements}',
            deadline = '{$deadline}'
            WHERE id = {$job_id}";
    
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}

function deleteJobPost($job_id){
    $con = getConnection();
    $sql = "DELETE FROM jobs WHERE id = {$job_id}";
    if(mysqli_query($con, $sql)){
        return true;
    }
    return false;
}

function getJobApplicants($user_id){
    $con = getConnection();
    $sql = "SELECT a.*, j.job_title, s.full_name, s.phone, s.resume_file, u.email
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            WHERE j.company_id = (SELECT id FROM companies WHERE user_id = {$user_id})
            ORDER BY a.applied_date DESC";
    $result = mysqli_query($con, $sql);
    
    $applicants = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($applicants, $row);
    }
    return $applicants;
}

function shortlistCandidate($company_id, $application_id){
    $con = getConnection();
    
    // Update application status
    $sql = "UPDATE applications SET application_status = 'shortlisted' WHERE id = {$application_id}";
    mysqli_query($con, $sql);
    
    // Add to shortlisted candidates
    $sql2 = "INSERT INTO shortlisted_candidates (application_id, company_id) VALUES ({$application_id}, {$company_id})";
    if(mysqli_query($con, $sql2)){
        return true;
    }
    return false;
}

function scheduleInterview($application_id, $data){
    $con = getConnection();
    
    $interview_date = mysqli_real_escape_string($con, $data['interview_date']);
    $interview_time = mysqli_real_escape_string($con, $data['interview_time']);
    $interview_mode = mysqli_real_escape_string($con, $data['interview_mode']);
    $interview_link = mysqli_real_escape_string($con, $data['interview_link']);
    $interview_location = mysqli_real_escape_string($con, $data['interview_location']);
    $notes = mysqli_real_escape_string($con, $data['notes']);
    
    $sql = "INSERT INTO interviews (application_id, interview_date, interview_time, interview_mode, interview_link, interview_location, notes)
            VALUES ({$application_id}, '{$interview_date}', '{$interview_time}', '{$interview_mode}', '{$interview_link}', '{$interview_location}', '{$notes}')";
    
    if(mysqli_query($con, $sql)){
        // Update application status
        $sql2 = "UPDATE applications SET application_status = 'interview_scheduled' WHERE id = {$application_id}";
        mysqli_query($con, $sql2);
        return true;
    }
    return false;
}

function updateInterviewResult($interview_id, $result){
    $con = getConnection();
    $result = mysqli_real_escape_string($con, $result);
    
    $sql = "UPDATE interviews SET result = '{$result}' WHERE id = {$interview_id}";
    
    if(mysqli_query($con, $sql)){
        // Update application status
        $sql2 = "SELECT application_id FROM interviews WHERE id = {$interview_id}";
        $res = mysqli_query($con, $sql2);
        $interview = mysqli_fetch_assoc($res);
        
        $sql3 = "UPDATE applications SET application_status = '{$result}' WHERE id = {$interview['application_id']}";
        mysqli_query($con, $sql3);
        
        return true;
    }
    return false;
}

function getCompanyById($conn, $user_id){
    $sql = "SELECT c.*, u.email, u.username 
            FROM companies c
            JOIN users u ON c.user_id = u.id
            WHERE c.user_id = {$user_id}";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getCompanyInterviews($conn, $user_id){
    $sql = "SELECT i.*, a.student_id, s.full_name as student_name, j.job_title,
            i.interview_mode as interview_type, 
            COALESCE(i.interview_link, i.interview_location) as location
            FROM interviews i
            JOIN applications a ON i.application_id = a.id
            JOIN students s ON a.student_id = s.id
            JOIN jobs j ON a.job_id = j.id
            WHERE j.company_id = (SELECT id FROM companies WHERE user_id = {$user_id})
            ORDER BY i.interview_date DESC, i.interview_time DESC";
    $result = mysqli_query($conn, $sql);
    
    $interviews = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($interviews, $row);
    }
    return $interviews;
}

function getShortlistedCandidates($conn, $user_id){
    $sql = "SELECT a.*, s.full_name, u.email, s.phone, s.degree, s.university, s.experience, s.skills,
            j.job_title, s.resume_file as resume_path, a.applied_date as applied_at
            FROM shortlisted_candidates sc
            JOIN applications a ON sc.application_id = a.id
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            JOIN jobs j ON a.job_id = j.id
            WHERE j.company_id = (SELECT id FROM companies WHERE user_id = {$user_id})
            ORDER BY a.applied_date DESC";
    $result = mysqli_query($conn, $sql);
    
    $candidates = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($candidates, $row);
    }
    return $candidates;
}

function getApplicationById($conn, $application_id){
    $sql = "SELECT a.*, s.full_name, u.email, j.job_title
            FROM applications a
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            JOIN jobs j ON a.job_id = j.id
            WHERE a.id = {$application_id}";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getJobPerformanceStats($conn, $user_id){
    $sql = "SELECT j.id, j.job_title, j.created_at, j.status,
            COUNT(DISTINCT a.id) as total_applications,
            COUNT(DISTINCT CASE WHEN a.application_status = 'shortlisted' THEN a.id END) as shortlisted_count,
            COUNT(DISTINCT CASE WHEN a.application_status = 'interview_scheduled' THEN a.id END) as interview_count,
            COUNT(DISTINCT CASE WHEN a.application_status = 'selected' THEN a.id END) as selected_count,
            COUNT(DISTINCT CASE WHEN a.application_status = 'rejected' THEN a.id END) as rejected_count
            FROM jobs j
            LEFT JOIN applications a ON j.id = a.job_id
            WHERE j.company_id = (SELECT id FROM companies WHERE user_id = {$user_id})
            GROUP BY j.id
            ORDER BY j.created_at DESC";
    $result = mysqli_query($conn, $sql);
    
    $stats = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($stats, $row);
    }
    return $stats;
}

function updateCompanyProfile($conn, $user_id, $data){
    $company_name = mysqli_real_escape_string($conn, $data['company_name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $industry = mysqli_real_escape_string($conn, $data['industry']);
    $location = mysqli_real_escape_string($conn, $data['location']);
    $website = mysqli_real_escape_string($conn, $data['website']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    
    // Update companies table
    $sql = "UPDATE companies SET 
            company_name = '{$company_name}',
            industry = '{$industry}',
            location = '{$location}',
            website = '{$website}',
            description = '{$description}'
            WHERE user_id = {$user_id}";
    mysqli_query($conn, $sql);
    
    // Update users table email
    $sql2 = "UPDATE users SET email = '{$email}' WHERE id = {$user_id}";
    if(mysqli_query($conn, $sql2)){
        return true;
    }
    return false;
}
?>
