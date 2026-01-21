<?php
session_start();
require_once('../../model/counselorModel.php');

if(!isset($_COOKIE['status']) || $_SESSION['user_type'] != 'student'){
    header('location: ../login.php?error=badrequest');
    exit();
}

$counselors = getAllCounselors();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Career Counselors - Student</title>
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
        <h2>Available Career Counselors</h2>
        
        <?php if(count($counselors) == 0): ?>
        <div class="alert alert-info">No counselors available at the moment.</div>
        <?php else: ?>
        <div class="dashboard-cards">
            <?php foreach($counselors as $counselor): ?>
            <div class="card">
                <h3><?=$counselor['full_name']?></h3>
                <p><strong>Specialization:</strong> <?=$counselor['specialization']?></p>
                <p><strong>Experience:</strong> <?=$counselor['experience_years']?> years</p>
                <?php if($counselor['qualification'] != ""): ?>
                <p><strong>Qualification:</strong> <?=$counselor['qualification']?></p>
                <?php endif; ?>
                <?php if($counselor['bio'] != ""): ?>
                <p><?=substr($counselor['bio'], 0, 150)?>...</p>
                <?php endif; ?>
                <a href="applyConsultation.php?id=<?=$counselor['id']?>" class="btn btn-primary">Book Consultation</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
