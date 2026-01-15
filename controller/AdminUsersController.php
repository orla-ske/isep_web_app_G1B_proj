<?php
// controller/AdminUsersController.php

session_start();
require_once '../model/connection.php';
require_once '../model/adminModel.php';

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

// Handle actions
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update':
                $userId = intval($_POST['user_id']);
                $data = array(
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'role' => $_POST['role'],
                    'city' => $_POST['city'],
                    'address' => $_POST['address'],
                    'postal_code' => $_POST['postal_code']
                );
                
                if ($adminModel->updateUser($userId, $data)) {
                    $adminModel->logActivity(
                        $currentUser['id'],
                        'update',
                        'users',
                        $userId,
                        'Updated user information'
                    );
                    $message = 'User updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to update user.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete':
                $userId = intval($_POST['user_id']);
                
                if ($adminModel->deleteUser($userId)) {
                    $adminModel->logActivity(
                        $currentUser['id'],
                        'delete',
                        'users',
                        $userId,
                        'Deleted user account'
                    );
                    $message = 'User deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to delete user.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get filters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$roleFilter = isset($_GET['role']) ? $_GET['role'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// Get users
$users = getAllUsers($search, $roleFilter, $limit, $offset);
$totalUsers = getUserCount($search, $roleFilter);
$totalPages = ceil($totalUsers / $limit);

// Get single user if editing
$editUser = null;
if (isset($_GET['edit'])) {
    $editUser = getUserById(intval($_GET['edit']));
}

// Include the view
include '../views/admin_users_view.php';
?>
