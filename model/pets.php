<?php
    include 'connection.php';

    function getAllPets() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM pets");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function getPetById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM pets WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function createPet($name, $type, $age, $owner_id) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO pet (name, type, age, owner_id) VALUES (:name, :type, :age, :owner_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':owner_id', $owner_id);
        return $stmt->execute();
    }

    function updatePet($id, $name, $breed, $age) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE pet SET name = :name, breed = :breed, age = :age WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':age', $age);
        return $stmt->execute();
    }

    function getUserPets($user_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE Users_id = :user_id 
                  ORDER BY name ASC";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    function addPet($user_id, $name, $breed, $age, $photo_url = null) {
        $query = "INSERT INTO " . $this->table . " 
                  (Users_id, name, breed, age, photo_url) 
                  VALUES (:user_id, :name, :breed, :age, :photo_url)";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':photo_url', $photo_url);
        
        return $stmt->execute();
    }

    function getPetById($pet_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $pet_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
?>