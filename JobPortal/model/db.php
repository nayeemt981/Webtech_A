<?php
// Database connection configuration

$host = "127.0.0.1";
$dbuser = "root";
$dbpass = "";
$dbname = "job_portal";

function getConnection(){
    global $host, $dbname, $dbpass, $dbuser;
    $con = mysqli_connect($host, $dbuser, $dbpass, $dbname);
    if(!$con){
        die("Connection failed: " . mysqli_connect_error());
    }
    return $con;
}
?>
