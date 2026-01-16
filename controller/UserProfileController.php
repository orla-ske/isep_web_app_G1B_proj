<?php
session_start();
require_once '../model/connection.php';
require_once '../model/users.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success_message = '';

// Get current user data
$user = getUserById($user_id);

if (!$user) {
    die("User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Handle Profile Update
    if (isset($_POST['update_profile'])) {
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $postal_code = trim($_POST['postal_code'] ?? '');
        $address = trim($_POST['address'] ?? '');
        
        // Validation
        if (empty($first_name)) $errors[] = "First name is required";
        if (empty($last_name)) $errors[] = "Last name is required";
        if (empty($email)) $errors[] = "Email is required";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
        
        // Check if email is taken by another user
        if ($email !== $user['email']) {
            $existing_user = getUserByEmail($email);
            if ($existing_user && $existing_user['id'] != $user_id) {
                $errors[] = "Email is already taken";
            }
        }
        
        if (empty($errors)) {
            $userData = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'city' => $city,
                'postal_code' => $postal_code,
                'address' => $address
            ];
            
            if (updateUserProfile($user_id, $userData)) {
                $success_message = "Profile updated successfully!";
                $_SESSION['user_name'] = $first_name; // Update session if needed
                $user = getUserById($user_id); // Refresh user data
            } else {
                $errors[] = "Failed to update profile. Please try again.";
            }
        }
    }
    
    // Handle Password Change
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validation
        if (empty($current_password)) $errors[] = "Current password is required";
        if (empty($new_password)) $errors[] = "New password is required";
        if (strlen($new_password) < 6) $errors[] = "Password must be at least 6 characters";
        if ($new_password !== $confirm_password) $errors[] = "Passwords do not match";
        
        // Verify current password
        if (!empty($current_password) && !verifyPassword($current_password, $user['password'])) {
            $errors[] = "Current password is incorrect";
        }
        
        if (empty($errors)) {
            if (updateUserPassword($user_id, $new_password)) {
                $success_message = "Password changed successfully!";
            } else {
                $errors[] = "Failed to change password. Please try again.";
            }
        }
    }
    
    // Handle Profile Picture Upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profiles/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            // Delete old profile picture if exists
            if (!empty($user['profile_picture']) && file_exists('../' . $user['profile_picture'])) {
                unlink('../' . $user['profile_picture']);
            }
            
            $new_filename = 'profile_' . $user_id . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                $profile_picture_url = 'uploads/profiles/' . $new_filename;
                if (updateProfilePicture($user_id, $profile_picture_url)) {
                    $success_message = "Profile picture updated successfully!";
                    $user = getUserById($user_id); // Refresh user data
                } else {
                    $errors[] = "Failed to update profile picture in database";
                }
            } else {
                $errors[] = "Failed to upload profile picture";
            }
        } else {
            $errors[] = "Invalid file type. Only JPG, PNG, and GIF allowed";
        }
    }
}

// Load the view
require_once '../views/userProfile.php';
?>