<?php
include 'connection.php';

function getPetById($id) {
    global $pdo;
    $query = "SELECT p.*, u.first_name AS owner_first_name, u.last_name AS owner_last_name, u.role AS owner_role
              FROM Pet p
              LEFT JOIN users u ON p.Users_id = u.id
              WHERE p.id = ? LIMIT 0,1";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllPets() {
    global $pdo;
    $query = "SELECT * FROM Pet";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserPets($user_id) {
    global $pdo;
    $query = "SELECT id, name, breed, age, photo_url 
              FROM Pet 
              WHERE Users_id = :user_id 
              ORDER BY name ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertPet($data) {
    global $pdo;
    $query = "INSERT INTO Pet 
              (Users_id, name, breed, age, gender, weight, height, color, vaccintation_status, photo_url, is_active) 
              VALUES (:user_id, :name, :breed, :age, :gender, :weight, :height, :color, :vaccintation_status, :photo_url, :is_active)";
    
    $stmt = $pdo->prepare($query);
    
    // Map array keys to bound parameters
    $stmt->bindParam(':user_id', $data['owner_id'], PDO::PARAM_INT);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':breed', $data['breed']);
    $stmt->bindParam(':age', $data['age'], PDO::PARAM_INT);
    $stmt->bindParam(':gender', $data['gender']);
    $stmt->bindParam(':weight', $data['weight']);
    $stmt->bindParam(':height', $data['height']);
    $stmt->bindParam(':color', $data['color']);
    $stmt->bindParam(':vaccintation_status', $data['vaccintation_status']);
    $stmt->bindParam(':photo_url', $data['photo_url']);
    $stmt->bindParam(':is_active', $data['is_active']);
    
    return $stmt->execute();
}

function updatePet($id, $name, $breed, $age) {
    global $pdo;
    $query = "UPDATE Pet 
              SET name = :name, breed = :breed, age = :age 
              WHERE id = :id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':breed', $breed);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    
    return $stmt->execute();
}

function updateFullPetProfile($data) {
    global $pdo;
    $query = "UPDATE Pet 
              SET name = :name, 
                  breed = :breed, 
                  age = :age, 
                  gender = :gender, 
                  weight = :weight, 
                  height = :height, 
                  color = :color, 
                  vaccintation_status = :vaccination_status, 
                  is_active = :is_active";
    
    // Only update photo if a new one is provided
    if (!empty($data['photo_url'])) {
        $query .= ", photo_url = :photo_url";
    }

    $query .= " WHERE id = :id";
    
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':breed', $data['breed']);
    $stmt->bindParam(':age', $data['age'], PDO::PARAM_INT);
    $stmt->bindParam(':gender', $data['gender']);
    $stmt->bindParam(':weight', $data['weight']);
    $stmt->bindParam(':height', $data['height']);
    $stmt->bindParam(':color', $data['color']);
    $stmt->bindParam(':vaccination_status', $data['vaccination_status']);
    $stmt->bindParam(':is_active', $data['is_active']);
    $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

    if (!empty($data['photo_url'])) {
        $stmt->bindParam(':photo_url', $data['photo_url']);
    }
    
    return $stmt->execute();
}
?>
