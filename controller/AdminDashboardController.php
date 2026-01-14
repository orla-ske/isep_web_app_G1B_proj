<?php
// controller/AdminDashboardController.php

session_start();
require_once '../model/connection.php';
require_once '../model/AdminModel.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$database = new Database();
$conn = $database->getConnection();
$adminModel = new AdminModel($conn);

$currentUser = array(
    'id' => $_SESSION['user_id'],
    'first_name' => $_SESSION['first_name'] ?? 'Admin',
    'last_name' => $_SESSION['last_name'] ?? '',
    'role' => $_SESSION['role']
);

// Get dashboard statistics
$stats = $adminModel->getDashboardStats();
$recentActivity = $adminModel->getRecentActivity(10);

// Include the view
include '../view/admin_dashboard_view.php';
?>