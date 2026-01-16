<?php
// controller/AdminUsersController.php

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
$editUser = null;
$search = $_GET['search'] ?? '';
$roleFilter = $_GET['role'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 20;

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete') {
        $userId = $_POST['user_id'] ?? 0;
        if ($userId && $userId != $_SESSION['user_id']) {
            if (deleteUser($conn, $userId)) {
                $message = 'User deleted successfully';
                $messageType = 'success';
            } else {
                $message = 'Failed to delete user';
                $messageType = 'error';
            }
        } else {
            $message = 'Cannot delete your own account';
            $messageType = 'error';
        }
    }
    
    if ($action === 'update') {
        $userId = $_POST['user_id'] ?? 0;
        if ($userId) {
            $updateData = array(
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'role' => $_POST['role'] ?? '',
                'city' => $_POST['city'] ?? '',
                'address' => $_POST['address'] ?? '',
                'postal_code' => $_POST['postal_code'] ?? ''
            );
            
            if (updateUserInfo($conn, $userId, $updateData)) {
                $message = 'User updated successfully';
                $messageType = 'success';
                header("Location: AdminUsersController.php?success=updated");
                exit();
            } else {
                $message = 'Failed to update user';
                $messageType = 'error';
            }
        }
    }
}

// Handle edit request
if (isset($_GET['edit'])) {
    $editUserId = (int)$_GET['edit'];
    $editUser = getUserById($conn, $editUserId);
}

// Get users with filters and statistics
$users = getUsersWithFilters($conn, $search, $roleFilter, $page, $perPage);

// Get total count for pagination
$totalUsers = getTotalUsersCount($conn, $search, $roleFilter);
$totalPages = ceil($totalUsers / $perPage);

// Success message from redirect
if (isset($_GET['success']) && $_GET['success'] === 'updated') {
    $message = 'User updated successfully';
    $messageType = 'success';
}

// Include the view
include '../views/admin_users_view.php';
?>