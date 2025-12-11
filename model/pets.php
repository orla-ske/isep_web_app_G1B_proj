<?php
require_once 'connection.php';

function getAllPets() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Pet");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPetById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Pet WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createPet($name, $type, $age, $owner_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO Pet (name, type, age, owner_id) 
        VALUES (:name, :type, :age, :owner_id)
    ");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt->bindParam(':owner_id', $owner_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function updatePet($id, $name, $breed, $age) {
    global $pdo;
    $stmt = $pdo->prepare("
        UPDATE Pet 
        SET name = :name, breed = :breed, age = :age 
        WHERE id = :id
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':breed', $breed);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    return $stmt->execute();
}

// ✅ FIXED: Added global $pdo, changed Users_id to owner_id
function getUserPets($user_id) {
    global $pdo;
    
    $query = "SELECT id, name, breed, age, photo_url 
              FROM Pet 
              WHERE owner_id = :user_id 
              ORDER BY name ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ✅ FIXED: Added global $pdo, changed Users_id to owner_id
function addPet($user_id, $name, $breed, $age, $photo_url = null) {
    global $pdo;
    
    $query = "INSERT INTO Pet 
              (owner_id, name, breed, age, photo_url) 
              VALUES (:user_id, :name, :breed, :age, :photo_url)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':breed', $breed);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt->bindParam(':photo_url', $photo_url);
    
    return $stmt->execute();
}

function insertPet($data) {
    global $pdo;
    
    $query = "INSERT INTO Pet 
              (owner_id, name, breed, age, gender, weight, height, color, vaccintation_status, photo_url, is_active) 
              VALUES (:owner_id, :name, :breed, :age, :gender, :weight, :height, :color, :vaccintation_status, :photo_url, :is_active)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':owner_id', $data['owner_id'], PDO::PARAM_INT);
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
?>