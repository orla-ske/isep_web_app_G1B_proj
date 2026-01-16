<?php
// controller/AdminJobsController.php

session_start();
require_once '../model/connection.php';
require_once '../model/AdminModel.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: ../login.html");
    exit();
}

$conn = $pdo;

// Initialize variables
$message = '';
$messageType = '';
$editJob = null;
$search = $_GET['search'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 20;

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete') {
        $jobId = $_POST['job_id'] ?? 0;
        if ($jobId) {
            if (deleteJob($conn, $jobId)) {
                $message = 'Job deleted successfully';
                $messageType = 'success';
            } else {
                $message = 'Failed to delete job';
                $messageType = 'error';
            }
        }
    }
    
    if ($action === 'update') {
        $jobId = $_POST['job_id'] ?? 0;
        if ($jobId) {
            $updateData = array(
                'status' => $_POST['status'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'service_type' => $_POST['service_type'] ?? '',
                'start_time' => $_POST['start_time'] ?? null,
                'end_time' => $_POST['end_time'] ?? null,
                'location' => $_POST['location'] ?? ''
            );
            
            if (updateJobInfo($conn, $jobId, $updateData)) {
                $message = 'Job updated successfully';
                $messageType = 'success';
                header("Location: AdminJobsController.php?success=updated");
                exit();
            } else {
                $message = 'Failed to update job';
                $messageType = 'error';
            }
        }
    }
}

// Handle edit request
if (isset($_GET['edit'])) {
    $editJobId = (int)$_GET['edit'];
    $editJob = getJobById($conn, $editJobId);
}

// Get jobs with filters
$jobs = getJobsWithFilters($conn, $search, $statusFilter, $page, $perPage);

// Get total count for pagination
$totalJobs = getTotalJobsCount($conn, $search, $statusFilter);
$totalPages = ceil($totalJobs / $perPage);

// Success message from redirect
if (isset($_GET['success']) && $_GET['success'] === 'updated') {
    $message = 'Job updated successfully';
    $messageType = 'success';
}

// Include the view
include '../views/admin_jobs_view.php';
?>