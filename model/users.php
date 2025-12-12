<?php
    include 'connection.php';
    function getAllUsers() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getUserById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function hashPassword($password) {
        // return password_hash($password, PASSWORD_BCRYPT);
        return $password;
    }

    function verifyPassword($password, $hash) {
        return $password == $hash;
    }

    function createUser($firstname, $lastname, $email, $password) {
        global $pdo;
        $password = hashPassword($password);
        $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)");
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    function getUserByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateUser($id, $firstname, $lastname, $email) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    function getuserbyusername($username) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getAllCaregivers() {
        $query = "SELECT * FROM " . $this->table . " WHERE role = 'caregiver'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    function getAllpetOwners() {
        global $pdo; // Fix: use global $pdo instead of $this->conn
        $query = "SELECT * FROM users WHERE role = 'pet_owner'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function searchCaregivers($searchTerm) {
        global $pdo;
        $searchTerm = "%$searchTerm%";
        $query = "SELECT * FROM users 
                  WHERE role = 'caregiver' 
                  AND (
                      first_name LIKE :search 
                      OR last_name LIKE :search 
                      OR city LIKE :search 
                      OR address LIKE :search
                  )";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function updateUserProfile($id, $data) {
    global $pdo;
    
    $query = "UPDATE users 
              SET first_name = :first_name, 
                  last_name = :last_name, 
                  email = :email, 
                  phone = :phone, 
                  city = :city, 
                  postal_code = :postal_code, 
                  address = :address
              WHERE id = :id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':first_name', $data['first_name']);
    $stmt->bindParam(':last_name', $data['last_name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':city', $data['city']);
    $stmt->bindParam(':postal_code', $data['postal_code']);
    $stmt->bindParam(':address', $data['address']);
    
    return $stmt->execute();
}

function updateUserPassword($id, $new_password) {
    global $pdo;
    
    $hashed_password = hashPassword($new_password);
    
    $query = "UPDATE users SET password = :password WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':password', $hashed_password);
    
    return $stmt->execute();
}

function updateProfilePicture($id, $profile_picture_url) {
    global $pdo;
    
    $query = "UPDATE users SET profile_picture = :profile_picture WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':profile_picture', $profile_picture_url);
    
    return $stmt->execute();
}
?>