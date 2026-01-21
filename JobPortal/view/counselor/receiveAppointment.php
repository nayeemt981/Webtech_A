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

$appointments = getCounselorAppointments($counselor['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Appointment Requests - Counselor</title>
    <link rel="stylesheet" href="../../asset/css/style.css">
    <script src="../../asset/js/ajax.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>Job Portal - Counselor</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="receiveAppointment.php">Appointments</a>
        <a href="../../controller/logoutController.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Consultation Appointment Requests</h2>
        
        <?php if(count($appointments) == 0): ?>
        <div class="alert alert-info">No appointment requests yet.</div>
        <?php else: ?>
        <table>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>Mode</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($appointments as $app): ?>
            <tr>
                <td><?=$app['full_name']?></td>
                <td><?=$app['email']?></td>
                <td><?=$app['phone']?></td>
                <td><?=$app['appointment_date']?></td>
                <td><?=$app['appointment_time']?></td>
                <td><?=$app['session_mode']?></td>
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
                    <?php if($app['status'] == 'requested'): ?>
                    <button onclick="approveConsultation(<?=$app['id']?>)" class="btn btn-primary">Approve</button>
                    <?php elseif($app['status'] == 'approved'): ?>
                    <a href="feedbackSession.php?id=<?=$app['id']?>" class="btn btn-primary">Give Feedback</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    
    <script>
    function approveConsultation(consultationId){
        let data = JSON.stringify({'consultation_id': consultationId, 'status': 'approved'});
        
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../../controller/updateConsultationStatusController.php', true);
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
    </script>
</body>
</html>
