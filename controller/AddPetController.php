<?php
session_start();
require_once '../model/connection.php';
require_once '../model/pets.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $name = trim($_POST['name'] ?? '');
    $breed = trim($_POST['breed'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $weight = trim($_POST['weight'] ?? '');
    $height = trim($_POST['height'] ?? '');
    $color = trim($_POST['color'] ?? '');
    $vaccintation_status = trim($_POST['vaccintation_status'] ?? '');
    
    // Validation
    if (empty($name)) $errors[] = "Pet name is required";
    if (empty($breed)) $errors[] = "Breed is required";
    if (empty($age) || !is_numeric($age) || $age < 0) $errors[] = "Valid age is required";
    if (empty($gender)) $errors[] = "Gender is required";
    if (empty($weight) || !is_numeric($weight) || $weight <= 0) $errors[] = "Valid weight is required";
    
    // Handle photo upload
    $photo_url = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/pets/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            $new_filename = uniqid('pet_') . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                $photo_url = 'uploads/pets/' . $new_filename;
            } else {
                $errors[] = "Failed to upload photo";
            }
        } else {
            $errors[] = "Invalid file type. Only JPG, PNG, and GIF allowed";
        }
    }
    
    // If no errors, insert pet
    if (empty($errors)) {
        $petData = [
            'owner_id' => $user_id,
            'name' => $name,
            'breed' => $breed,
            'age' => $age,
            'gender' => $gender,
            'weight' => $weight,
            'height' => $height ?? null,
            'color' => $color ?? null,
            'vaccintation_status' => $vaccintation_status ?? 'Unknown',
            'photo_url' => $photo_url,
            'is_active' => 'yes'
        ];
        
        if (insertPet($petData)) {
            $success = true;
            $_SESSION['success_message'] = "Pet added successfully!";
            header('Location: DashboardController.php');
            exit;
        } else {
            $errors[] = "Failed to add pet. Please try again.";
        }
    }
}

// Load the view
require_once '../views/addPet.php';
?>