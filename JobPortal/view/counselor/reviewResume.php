<?php
session_start();
require_once('../../model/counselorModel.php');
require_once('../../model/studentModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'counselor'){
    header('location: ../login.php?error=badrequest');
    exit();
}

// Get counselor ID from user_id
$conn = getConnection();
$counselor = getCounselorByUserId($conn, $_SESSION['user_id']);

if(!$counselor){
    echo "Error: Counselor profile not found";
    exit();
}

// Get students who have uploaded resumes
$query = "SELECT s.id, s.degree, s.university, s.skills, s.resume_file, u.username, u.email, 
          (SELECT full_name FROM students WHERE user_id = u.id) as full_name
          FROM students s 
          JOIN users u ON s.user_id = u.id 
          WHERE s.resume_file IS NOT NULL AND s.resume_file != ''
          ORDER BY s.id DESC";

$result = mysqli_query($conn, $query);
$students = array();
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $students[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Review Resumes - Counselor</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Counselor</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="receiveAppointment.php">Appointments</a>
        <a href="reviewResume.php">Review Resumes</a>
        <a href="feedbackSession.php">Provide Feedback</a>
        <a href="changePassword.php">Change Password</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Student Resumes for Review</h2>
        <p>Review and provide feedback on student resumes</p>
        
        <?php if(count($students) == 0): ?>
        <div class="alert alert-info">No student resumes available for review.</div>
        <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Degree</th>
                    <th>University</th>
                    <th>Skills</th>
                    <th>Resume</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($students as $student): ?>
                <tr>
                    <td><?=$student['full_name']?></td>
                    <td><?=$student['email']?></td>
                    <td><?=$student['degree']?></td>
                    <td><?=$student['university']?></td>
                    <td><?=$student['skills']?></td>
                    <td>
                        <?php if($student['resume_file']): ?>
                            <a href="../../asset/uploads/<?=$student['resume_file']?>" target="_blank" class="btn-small">View Resume</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
