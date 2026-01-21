<?php
require_once('db.php');

function changeUserPassword($user_id, $old_password, $new_password){
    $con = getConnection();
    
    // Get current password
    $sql = "SELECT password FROM users WHERE id = {$user_id}";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    
    // Verify old password
    if(password_verify($old_password, $user['password'])){
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql2 = "UPDATE users SET password = '{$hashed_password}' WHERE id = {$user_id}";
        
        if(mysqli_query($con, $sql2)){
            return true;
        }
    }
    return false;
}

function resetUserPassword($email, $new_password){
    $con = getConnection();
    $email = mysqli_real_escape_string($con, $email);
    
    $sql = "SELECT id FROM users WHERE email = '{$email}'";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) == 1){
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql2 = "UPDATE users SET password = '{$hashed_password}' WHERE email = '{$email}'";
        
        if(mysqli_query($con, $sql2)){
            return true;
        }
    }
    return false;
}
?>
