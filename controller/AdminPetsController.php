<?php
// controller/AdminPetsController.php

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
$editPet = null;
$search = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 20;

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete') {
        $petId = $_POST['pet_id'] ?? 0;
        if ($petId) {
            if (deletePet($conn, $petId)) {
                $message = 'Pet deleted successfully';
                $messageType = 'success';
            } else {
                $message = 'Failed to delete pet';
                $messageType = 'error';
            }
        }
    }
    
    if ($action === 'update') {
        $petId = $_POST['pet_id'] ?? 0;
        if ($petId) {
            $updateData = array(
                'name' => $_POST['name'] ?? '',
                'breed' => $_POST['breed'] ?? '',
                'age' => $_POST['age'] ?? 0,
                'gender' => $_POST['gender'] ?? '',
                'weight' => $_POST['weight'] ?? null,
                'height' => $_POST['height'] ?? null,
                'color' => $_POST['color'] ?? '',
                'vaccintation_status' => $_POST['vaccintation_status'] ?? '',
                'is_active' => $_POST['is_active'] ?? 'yes'
            );
            
            if (updatePetInfo($conn, $petId, $updateData)) {
                $message = 'Pet updated successfully';
                $messageType = 'success';
                header("Location: AdminPetsController.php?success=updated");
                exit();
            } else {
                $message = 'Failed to update pet';
                $messageType = 'error';
            }
        }
    }
}

// Handle edit request
if (isset($_GET['edit'])) {
    $editPetId = (int)$_GET['edit'];
    $editPet = getPetById($conn, $editPetId);
}

// Get pets with filters
$pets = getPetsWithFilters($conn, $search, $page, $perPage);

// Get total count for pagination
$totalPets = getTotalPetsCount($conn, $search);
$totalPages = ceil($totalPets / $perPage);

// Success message from redirect
if (isset($_GET['success']) && $_GET['success'] === 'updated') {
    $message = 'Pet updated successfully';
    $messageType = 'success';
}

// Include the view
include '../views/admin_pets_view.php';
?>