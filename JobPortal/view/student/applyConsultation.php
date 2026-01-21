<?php
session_start();
require_once('../../model/counselorModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'student'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$counselor_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

if(!$counselor_id){
    header('location: viewCounselors.php?error=Invalid counselor');
    exit();
}

$conn = getConnection();
$counselor = getCounselorById($conn, $counselor_id);

if(!$counselor){
    header('location: viewCounselors.php?error=Counselor not found');
    exit();
}

$success = isset($_REQUEST['success']) ? $_REQUEST['success'] : '';
$error = isset($_REQUEST['error']) ? $_REQUEST['error'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Consultation - Student</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Student</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="viewCounselors.php">Counselors</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Book Consultation</h2>
        
        <?php if($success){ ?>
            <div class="success-msg"><?=$success?></div>
        <?php } ?>
        
        <?php if($error){ ?>
            <div class="error-msg"><?=$error?></div>
        <?php } ?>
        
        <div class="profile-section">
            <h3>Counselor Information</h3>
            <div class="profile-info">
                <p><strong>Name:</strong> <?=$counselor['full_name']?></p>
                <p><strong>Specialization:</strong> <?=$counselor['specialization']?></p>
                <p><strong>Experience:</strong> <?=$counselor['experience_years']?> years</p>
                <?php if($counselor['qualification']){ ?>
                    <p><strong>Qualification:</strong> <?=$counselor['qualification']?></p>
                <?php } ?>
            </div>
        </div>
        
        <form action="../../controller/bookConsultationController.php" method="POST">
            <input type="hidden" name="counselor_id" value="<?=$counselor_id?>">
            
            <table>
                <tr>
                    <td>Preferred Date:</td>
                    <td><input type="date" name="preferred_date" required></td>
                </tr>
                <tr>
                    <td>Preferred Time:</td>
                    <td><input type="time" name="preferred_time" required></td>
                </tr>
                <tr>
                    <td>Session Mode:</td>
                    <td>
                        <select name="session_mode" required>
                            <option value="">Select Mode</option>
                            <option value="online">Online</option>
                            <option value="onsite">Onsite</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Consultation Topic:</td>
                    <td>
                        <select name="consultation_topic" required>
                            <option value="">Select Topic</option>
                            <option value="Career Guidance">Career Guidance</option>
                            <option value="Resume Review">Resume Review</option>
                            <option value="Interview Preparation">Interview Preparation</option>
                            <option value="Job Search Strategy">Job Search Strategy</option>
                            <option value="Other">Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Description/Message:</td>
                    <td><textarea name="message" rows="5" placeholder="Describe what you need help with..." required></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Book Consultation" class="btn btn-primary">
                        <a href="viewCounselors.php" class="btn btn-secondary">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
