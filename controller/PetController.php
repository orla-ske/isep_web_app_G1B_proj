<?php
include_once '../config/database.php';
include_once '../models/Pet.php';

class PetController {
    public function showProfile($id) {
        $database = new Database();
        $db = $database->getConnection();

        $pet = new Pet($db);
        
        if($pet->getPetById($id)) {
            // Pass data to view
            include '../views/pet_profile.php';
        } else {
            echo "Pet not found.";
        }
    }
}

// Simple routing for demonstration
if (isset($_GET['id'])) {
    $controller = new PetController();
    $controller->showProfile($_GET['id']);
} else {
    echo "No pet ID specified.";
}
?>