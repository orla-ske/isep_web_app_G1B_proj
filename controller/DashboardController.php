<?php
require_once '../model/users.php';
require_once '../model/jobs.php';
require_once '../model/pets.php';

// Handle AJAX requests first
if (isset($_GET['action']) && $_GET['action'] === 'start_job') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $job_id = $_POST['job_id'] ?? null;
        
        if ($job_id) {
            $result = updateJobStatus($job_id, 'In Progress');
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Job started']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to start job']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing job ID']);
        }
    }
    exit;
}

// Main dashboard logic
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}

$current_user_id = $_SESSION['user_id'];

// Get current user data
$currentUser = getUserById($current_user_id);

if (!$currentUser) {
    die("<div style='color:white; padding:20px'>User not found.</div>");
}

$role = $currentUser['role'];
$stats = [];
$listItems = [];
$pets = [];

// Initialize stats
$stats['earnings'] = 0;
$stats['pending_jobs'] = 0;
$stats['total_pets'] = 0;

if ($role === 'caregiver') {
    // Caregiver dashboard data
    $stats['earnings'] = getCaregiverEarnings($current_user_id);
    $listItems = getCaregiverUpcomingJobs($current_user_id);
    $stats['pending_jobs'] = count($listItems);
    // For caregivers
    $stats['avg_rating'] = getAverageRating($current_user_id);
    $stats['total_reviews'] = getTotalReviews($current_user_id);


} else {
    // Pet owner dashboard data
    $pets = getUserPets($current_user_id);
    $stats['total_pets'] = count($pets);
    $listItems = getOwnerJobs($current_user_id);
    // For pet owners
    $stats['total_spent'] = getTotalSpent($current_user_id);
    $stats['completed_jobs'] = getCompletedJobsCount($current_user_id);
    
    // Search for caregivers
    $caregiverSearchResults = [];
    if (isset($_GET['search_caregiver']) && !empty($_GET['search_caregiver'])) {
        $caregiverSearchResults = searchCaregivers($_GET['search_caregiver']);
    }
}

// Load the view
require_once '../views/dashboard.php';
?>