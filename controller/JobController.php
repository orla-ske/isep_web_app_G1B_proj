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
    if (isset($_POST['add_pet_ajax'])) {
        $pet_data = [
            'owner_id' => $_SESSION['user_id'],
            'name' => $_POST['pet_name'],
            'breed' => $_POST['pet_breed'],
            'age' => $_POST['pet_age'],
            'gender' => $_POST['pet_gender'],
            'weight' => null, 'height' => null, 'color' => null,
            'vaccintation_status' => 'Unknown',
            'photo_url' => null,
            'is_active' => 1
        ];
        
        if (insertPet($pet_data)) {
            echo json_encode(['success' => true, 'pet_id' => $pdo->lastInsertId(), 'pet_name' => $_POST['pet_name'], 'pet_breed' => $_POST['pet_breed']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add pet']);
        }
        exit;
    }

    // Handle job actions (for caregivers)
   if (isset($_POST['action']) && isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];
    $action = $_POST['action'];

    if ($action === 'apply') {
        // Caregiver applying for an open job
        $result = applyForJob($job_id, $user_id);
        if ($result) {
            $_SESSION['success_message'] = "Application submitted successfully! Waiting for owner approval.";
        } else {
            $_SESSION['error_message'] = "Failed to apply for job. It may already be taken.";
        }
    } elseif ($action === 'accept') {
        updateJobStatus($job_id, 'Confirmed');
        $_SESSION['success_message'] = "Job accepted successfully!";
    } elseif ($action === 'decline') {
        // Reset caregiver_id when declining
        if ($user_type === 'caregiver') {
            declineJobAsCaregiver($job_id);
        } else {
            declineJobAsOwner($job_id);
        }
        $_SESSION['success_message'] = "Job declined.";
    } elseif ($action === 'complete') {
        updateJobStatus($job_id, 'Completed');
        $_SESSION['success_message'] = "Job marked as completed!";
    }
        
        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
    
    // Handle job creation (for owners)
    if (isset($_POST['create_job'])) {
    $pet_id = $_POST['pet_id'];
    $service_type = $_POST['service_type'];
    $start_time = $_POST['start_date'] . ' ' . $_POST['start_time'];
    $end_time = $_POST['end_date'] . ' ' . $_POST['end_time'];
    $price = $_POST['price'];
    $location = $_POST['location'] ?? '';
    $caregiver_id = !empty($_POST['caregiver_id']) ? $_POST['caregiver_id'] : null;
    
    // Create job with or without assigned caregiver
    if (createJob($user_id, $pet_id, $service_type, $start_time, $end_time, $price, $location, $caregiver_id)) {
        if ($caregiver_id) {
            $_SESSION['success_message'] = "Job created and assigned to caregiver! Waiting for their acceptance.";
        } else {
            $_SESSION['success_message'] = "Job created successfully! Caregivers can now apply.";
        }
    } else {
        $_SESSION['error_message'] = "Failed to create job. Please try again.";
    }
}

// Get flash messages and clear them
$success_message = $_SESSION['success_message'] ?? null;
$error_message = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message'], $_SESSION['error_message']);

// Get data based on user type
$user_pets = [];
$open_jobs = [];
$available_caregivers = [];
$pending_applications = [];

if ($user_type === 'caregiver') {
    // Get caregiver's assigned jobs
    $jobs = getCaregiverUpcomingJobs($user_id);
    $total_earnings = getCaregiverEarnings($user_id);
    
    // Get open jobs available for application
    $open_jobs = getOpenJobs($user_id);
} else {
    // Get owner's jobs
    $jobs = getOwnerJobs($user_id);
    $user_pets = getUserPets($user_id);
    $available_caregivers = getAllCaregivers();
    $pending_applications = getJobApplications($user_id);
}

// Load the view
require_once '../views/jobBoard.php';
?>