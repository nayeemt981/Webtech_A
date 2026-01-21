<?php
session_start();

// Check authentication
if(!isset($_COOKIE['status'])){
    header('location: ../view/login.php?error=badrequest');
    exit();
}

// Check if company
if($_SESSION['user_type'] != 'company'){
    header('location: ../view/login.php?error=badrequest');
    exit();
}

require_once('../model/companyModel.php');

// Get form data
$company_name = isset($_REQUEST['company_name']) ? trim($_REQUEST['company_name']) : '';
$email = isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
$industry = isset($_REQUEST['industry']) ? trim($_REQUEST['industry']) : '';
$location = isset($_REQUEST['location']) ? trim($_REQUEST['location']) : '';
$website = isset($_REQUEST['website']) ? trim($_REQUEST['website']) : '';
$description = isset($_REQUEST['description']) ? trim($_REQUEST['description']) : '';

// Validation
if(empty($company_name) || empty($email) || empty($industry) || empty($location) || empty($description)){
    header('location: ../view/company/editProfile.php?error=All fields required');
    exit();
}

// Email validation
$atPos = strpos($email, '@');
$dotPos = strpos($email, '.');

if($atPos == false || $dotPos == false){
    header('location: ../view/company/editProfile.php?error=Invalid email format');
    exit();
}

// Prepare data
$data = [
    'company_name' => $company_name,
    'email' => $email,
    'industry' => $industry,
    'location' => $location,
    'website' => $website,
    'description' => $description
];

// Update profile
$conn = getConnection();
if(updateCompanyProfile($conn, $_SESSION['user_id'], $data)){
    header('location: ../view/company/profile.php?success=Profile updated successfully');
} else {
    header('location: ../view/company/editProfile.php?error=Failed to update profile');
}
?>
