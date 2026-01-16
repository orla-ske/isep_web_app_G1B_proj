<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}

require_once '../model/connection.php';
require_once '../model/pets.php';

// $pdo is defined in connection.php

// Handle POST request for updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_pet'])) {
    $pet_id = $_POST['pet_id'];
    
    // Check ownership or admin rights (basic check)
    $petData = getPetById($pet_id);
    if ($petData) {
        if ($petData['Users_id'] == $_SESSION['user_id']) {
            
            // Collect data
            $updateData = [
                'id' => $pet_id,
                'name' => $_POST['name'],
                'breed' => $_POST['breed'],
                'age' => $_POST['age'],
                'gender' => $_POST['gender'],
                'weight' => $_POST['weight'],
                'height' => $_POST['height'],
                'color' => $_POST['color'],
                'vaccination_status' => $_POST['vaccination_status'],
                'is_active' => $_POST['is_active'] ?? 'no',
                'photo_url' => ''
            ];

            // Handle File Upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../uploads/pets/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExtension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'pet_' . uniqid() . '.' . $fileExtension;
                    $uploadPath = $uploadDir . $newFileName;
                    
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
                        $updateData['photo_url'] = $uploadPath; 
                    }
                }
            }

            if (updateFullPetProfile($updateData)) {
                // Refresh data
                $petData = getPetById($pet_id);
                $success_message = "Profile updated successfully!";
            } else {
                $error_message = "Failed to update profile.";
            }

        } else {
            $error_message = "You are not authorized to edit this pet.";
        }
    } else {
        $error_message = "Pet not found.";
    }
} else if (isset($_GET['id'])) {
    $petData = getPetById($_GET['id']);
    if ($petData) {
        // Just loaded for view
    } else {
        echo "Pet not found.";
        exit;
    }
} else {
    echo "No pet ID specified.";
    exit;
}

// Prepare object for view
if (isset($petData) && is_array($petData)) {
    $pet = (object) $petData;
}

require_once '../views/pet_profile.php';
?>