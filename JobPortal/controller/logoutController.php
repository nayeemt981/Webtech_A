<?php
session_start();

// Clear session
session_unset();
session_destroy();

// Clear cookies
setcookie('status', '', time()-3600, '/');
setcookie('remember_user', '', time()-3600, '/');

header('location: ../view/login.php?success=logout');
?>
