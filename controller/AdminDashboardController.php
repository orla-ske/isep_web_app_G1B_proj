<?php
// ============================================================================
// controller/AdminDashboardController.php
// ============================================================================

session_start();
require_once '../model/connection.php';
require_once '../model/AdminModel.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: ../login.html");
    exit();
}

$conn = $pdo;

$currentUser = array(
    'id' => $_SESSION['user_id'],
    'first_name' => $_SESSION['first_name'] ?? 'Admin',
    'last_name' => $_SESSION['last_name'] ?? '',
    'role' => $_SESSION['role']
);

// Get dashboard statistics using AdminModel functions
$stats = getDashboardStats($conn);
$recentActivity = getRecentActivity($conn, 10);

// Include the view
include '../views/admin_dashboard_view.php';
?>

