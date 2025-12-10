<?php
session_start();
header('Content-Type: application/json'); // Return JSON for the JS frontend

// Include your existing user logic
require_once '../model/users.php'; 

$response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get raw POST data
    $action = $_POST['action'] ?? '';
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // --- LOGIN LOGIC ---
    if ($action === 'login') {
        if (empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
            exit;
        }

        $user = getUserByEmail($email);

        if ($user && verifyPassword($password, $user['password'])) {
            // Set Session Variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['firstname'] = $user['first_name'];
            $_SESSION['role'] = $user['role'];
            
            echo json_encode(['status' => 'success', 'message' => 'Login successful! Redirecting...']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        }
    } 
    
    // --- SIGNUP LOGIC ---
    elseif ($action === 'signup') {
        $firstname = trim($_POST['firstname'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        
        // Basic Validation
        if (empty($firstname) || empty($email) || empty($password) || empty($lastname)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
            exit;
        }

        // check if user exists
        if (getUserByEmail($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
            exit;
        }


        // Attempt to create user
        if (createUser($firstname, $lastname, $email, $password)) {
            // Optional: Auto-login after signup
            $newUser = getUserByEmail($email);
            $_SESSION['user_id'] = $newUser['id'];
            
            echo json_encode(['status' => 'success', 'message' => 'Account created! Redirecting...']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again.']);
        }
    } 
    else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>