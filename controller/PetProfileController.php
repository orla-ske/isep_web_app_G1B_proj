<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}

require_once '../model/connection.php';
require_once '../model/pet.php';

// $pdo is defined in connection.php
$pet = new Pet($pdo);

if (isset($_GET['id'])) {
    if ($pet->getPetById($_GET['id'])) {
        require_once '../views/pet_profile.php';
    } else {
        echo "Pet not found.";
    }
} else {
    echo "No pet ID specified.";
}
?>