<?php
session_start();
require_once('../../model/counselorModel.php');

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

$success = '';
$error = '';

// Get completed appointments that need feedback
$query = "SELECT c.id, c.appointment_date, c.appointment_time, c.student_notes, 
          s.degree, u.username, u.email,
          (SELECT full_name FROM students WHERE user_id = u.id) as full_name
          FROM consultations c
          JOIN students s ON c.student_id = s.id
          JOIN users u ON s.user_id = u.id
          WHERE c.counselor_id = {$counselor['id']} 
          AND c.status IN ('approved', 'completed')
          ORDER BY c.appointment_date DESC, c.appointment_time DESC";

$result = mysqli_query($conn, $query);
$appointments = array();
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $appointments[] = $row;
    }
}

// Handle feedback submission
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $consultation_id = mysqli_real_escape_string($conn, $_REQUEST['consultation_id']);
    $feedback_text = mysqli_real_escape_string($conn, $_REQUEST['feedback_text']);
    $rating = mysqli_real_escape_string($conn, $_REQUEST['rating']);
    
    if(empty($consultation_id) || empty($feedback_text) || empty($rating)){
        $error = "Please fill all required fields";
    } else {
        // Update consultation with feedback and mark as completed
        $query = "UPDATE consultations 
                  SET counselor_feedback = '$feedback_text', 
                      session_rating = '$rating',
                      status = 'completed'
                  WHERE id = '$consultation_id' AND counselor_id = {$counselor['id']}";
        
        if(mysqli_query($conn, $query)){
            $success = "Feedback submitted successfully";
            // Refresh appointments list
            header("Location: feedbackSession.php?success=1");
            exit();
        } else {
            $error = "Failed to submit feedback: " . mysqli_error($conn);
        }
    }
}

if(isset($_GET['success'])){
    $success = "Feedback submitted successfully";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session Feedback - Counselor</title>
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
        <h2>Provide Session Feedback</h2>
        <p>Give feedback on completed consultation sessions</p>
        
        <div class="success-msg"><?=$success?></div>
        <div class="error-msg"><?=$error?></div>
        
        <?php if(count($appointments) == 0): ?>
        <div class="alert alert-info">No consultations available for feedback.</div>
        <?php else: ?>
        
        <?php foreach($appointments as $app): ?>
        <div class="profile-section">
            <h3>Session with <?=$app['full_name']?></h3>
            <div class="profile-info">
                <p><strong>Date:</strong> <?=$app['appointment_date']?></p>
                <p><strong>Time:</strong> <?=$app['appointment_time']?></p>
                <p><strong>Student Email:</strong> <?=$app['email']?></p>
                <p><strong>Student Notes:</strong> <?=$app['student_notes']?></p>
            </div>
            
            <form method="POST" action="" style="margin-top: 20px;">
                <input type="hidden" name="consultation_id" value="<?=$app['id']?>">
                
                <label>Your Feedback:</label>
                <textarea name="feedback_text" rows="4" placeholder="Provide detailed feedback about the session" required></textarea>
                
                <label>Session Rating:</label>
                <select name="rating" required>
                    <option value="">Select Rating</option>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Very Good</option>
                    <option value="3">3 - Good</option>
                    <option value="2">2 - Fair</option>
                    <option value="1">1 - Poor</option>
                </select>
                
                <button type="submit">Submit Feedback</button>
            </form>
        </div>
        <?php endforeach; ?>
        
        <?php endif; ?>
    </div>
</body>
</html>
