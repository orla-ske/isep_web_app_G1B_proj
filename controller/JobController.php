<?php
session_start();
require_once '../model/connection.php';
require_once '../model/users.php';
require_once '../model/jobs.php';
require_once '../model/pets.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get current user data
$currentUser = getUserById($user_id);
if (!$currentUser) {
    die("User not found.");
}

$user_type = $currentUser['user_type'] ?? $currentUser['role'] ?? 'pet_owner';

// Handle AJAX/POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle job actions (for caregivers)
    if (isset($_POST['action']) && isset($_POST['job_id'])) {
        $job_id = $_POST['job_id'];
        $action = $_POST['action'];
        
        if ($action === 'apply') {
            // Caregiver applying for an open job
            $result = applyForJob($job_id, $user_id);
            if ($result) {
                $_SESSION['success_message'] = "Application submitted successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to apply for job. It may already be taken.";
            }
        } elseif ($action === 'accept') {
            updateJobStatus($job_id, 'Confirmed');
            $_SESSION['success_message'] = "Job accepted successfully!";
        } elseif ($action === 'decline') {
            updateJobStatus($job_id, 'Declined');
            $_SESSION['success_message'] = "Job declined.";
        } elseif ($action === 'complete') {
            updateJobStatus($job_id, 'Completed');
            $_SESSION['success_message'] = "Job marked as completed!";
        }
        
        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    // Handle job creation (for owners)
    if (isset($_POST['create_job'])) {
        $pet_id = $_POST['pet_id'];
        $service_type = $_POST['service_type'];
        $start_time = $_POST['start_date'] . ' ' . $_POST['start_time'];
        $end_time = $_POST['end_date'] . ' ' . $_POST['end_time'];
        $price = $_POST['price'];
        $location = $_POST['location'] ?? '';
        
        // Create job without caregiver (open for applications)
        if (createOpenJob($user_id, $pet_id, $service_type, $start_time, $end_time, $price, $location)) {
            $_SESSION['success_message'] = "Job created successfully! Caregivers can now apply.";
        } else {
            $_SESSION['error_message'] = "Failed to create job. Please try again.";
        }
        
        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Get flash messages and clear them
$success_message = $_SESSION['success_message'] ?? null;
$error_message = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message'], $_SESSION['error_message']);

// Get data based on user type
$jobs = [];
$total_earnings = 0;
$user_pets = [];
$open_jobs = [];

if ($user_type === 'caregiver') {
    // Get caregiver's assigned jobs
    $jobs = getCaregiverUpcomingJobs($user_id);
    $total_earnings = getCaregiverEarnings($user_id);
    
    // Get open jobs available for application
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $open_jobs = searchOpenJobs($user_id, $_GET['search']);
    } else {
        $open_jobs = getOpenJobs($user_id);
    }
} else {
    // Get owner's jobs
    $jobs = getOwnerJobs($user_id);
    $user_pets = getUserPets($user_id);
}

// Load the view
require_once '../views/jobBoard.php';
?>