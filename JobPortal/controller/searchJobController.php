<?php
session_start();
require_once('../model/jobModel.php');

$data = $_POST['data'];
$decoded = json_decode($data, true);

$keyword = isset($decoded['keyword']) ? $decoded['keyword'] : '';
$category = isset($decoded['category']) ? $decoded['category'] : '';

$jobs = searchJobs($keyword, $category);

if(count($jobs) == 0){
    echo "<div class='alert alert-info'>No jobs found.</div>";
} else {
    foreach($jobs as $job){
        echo "<div class='job-card'>";
        echo "<h3>{$job['job_title']}</h3>";
        echo "<p class='company-name'>{$job['company_name']}</p>";
        echo "<div class='job-details'>";
        echo "<p><strong>Category:</strong> {$job['job_category']}</p>";
        echo "<p><strong>Type:</strong> {$job['job_type']}</p>";
        echo "<p><strong>Location:</strong> {$job['location']}</p>";
        echo "<p><strong>Salary:</strong> {$job['salary_range']}</p>";
        echo "</div>";
        echo "<div class='button-group'>";
        echo "<a href='jobDetails.php?id={$job['id']}' class='btn btn-primary'>View Details</a>";
        echo "<button onclick='shortlistJob({$job['id']})' class='btn btn-secondary'>Shortlist</button>";
        echo "</div>";
        echo "</div>";
    }
}
?>
