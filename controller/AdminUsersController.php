<?php
// ============================================================================
// controller/AdminUsersController.php
// ============================================================================

session_start();
require_once '../model/connection.php';
require_once '../model/users.php';
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
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone']),
                    'city' => trim($_POST['city']),
                    'address' => trim($_POST['address']),
                    'postal_code' => trim($_POST['postal_code'])
                );
                
                // Use updateUserProfile from users.php
                if (updateUserProfile($userId, $data)) {
                    $message = 'User updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to update user.';
                    $messageType = 'error';
                }
                break;
                
            case 'update_role':
                $userId = intval($_POST['user_id']);
                $role = trim($_POST['role']);
                
                // Use updateUser from AdminModel for role changes
                if (updateUser($conn, $userId, array('role' => $role))) {
                    $message = 'User role updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to update user role.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete':
                $userId = intval($_POST['user_id']);
                
                // Use deleteUser from AdminModel
                if (deleteUser($conn, $userId)) {
                    $message = 'User deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to delete user.';
                    $messageType = 'error';
                }
                break;
                
            case 'reset_password':
                $userId = intval($_POST['user_id']);
                $newPassword = trim($_POST['new_password']);
                
                // Use updateUserPassword from users.php
                if (updateUserPassword($userId, $newPassword)) {
                    $message = 'Password reset successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to reset password.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get filters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$roleFilter = isset($_GET['role']) ? trim($_GET['role']) : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 20;

// Get users using AdminModel
$users = getUsers($conn, $page, $perPage);
$totalUsers = getTotalUsers($conn);
$totalPages = ceil($totalUsers / $perPage);

// Apply search filter if provided
if (!empty($search)) {
    // Filter users array by search term
    $users = array_filter($users, function($user) use ($search) {
        $searchLower = strtolower($search);
        return stripos($user['first_name'], $search) !== false ||
               stripos($user['last_name'], $search) !== false ||
               stripos($user['email'], $search) !== false ||
               stripos($user['city'], $search) !== false;
    });
}

// Apply role filter if provided
if (!empty($roleFilter)) {
    $users = array_filter($users, function($user) use ($roleFilter) {
        return $user['role'] === $roleFilter;
    });
}

// Get single user if editing (using users.php function)
$editUser = null;
if (isset($_GET['edit'])) {
    $editUser = getUserById(intval($_GET['edit']));
}

// Get all caregivers and pet owners for statistics
$caregivers = getAllCaregivers();
$caregiversCount = count($caregivers);

// Include the view
include '../views/admin_users_view.php';
?>