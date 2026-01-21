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

// Get all completed and approved sessions
$appointments = getCounselorAppointments($counselor['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session History - Counselor</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Counselor</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="receiveAppointment.php">Appointments</a>
        <a href="viewSessionList.php">Session History</a>
        <a href="changePassword.php">Change Password</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Consultation Session History</h2>
        
        <?php if(count($appointments) == 0): ?>
        <div class="alert alert-info">No consultation sessions yet.</div>
        <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Mode</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($appointments as $app): ?>
                <tr>
                    <td><?=$app['full_name']?></td>
                    <td><?=$app['email']?></td>
                    <td><?=$app['phone']?></td>
                    <td><?=$app['appointment_date']?></td>
                    <td><?=$app['appointment_time']?></td>
                    <td><?=ucfirst($app['session_mode'])?></td>
                    <td>
                        <?php
                        if($app['status'] == 'requested'){
                            echo "<span class='status status-pending'>Requested</span>";
                        } elseif($app['status'] == 'approved'){
                            echo "<span class='status status-approved'>Approved</span>";
                        } elseif($app['status'] == 'completed'){
                            echo "<span class='status status-approved'>Completed</span>";
                        } elseif($app['status'] == 'cancelled'){
                            echo "<span class='status status-rejected'>Cancelled</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if($app['student_notes']): ?>
                            <small><?=substr($app['student_notes'], 0, 50)?>...</small>
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
