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

    function createUser($firstname, $lastname, $email, $password, $role) {
        global $pdo;
        $password = hashPassword($password);
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)");
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
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
        global $pdo;
        $query = "SELECT * FROM users WHERE role = 'caregiver'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllpetOwners() {
        $query = "SELECT * FROM " . $this->table . " WHERE role = 'pet_owner'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
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

function verifyUserByCode($email, $code) {
    global $pdo;
    $codeHash = hash('sha256', $code);

    // 获取当前 PHP 时间
    $currentProps = date('Y-m-d H:i:s');

    // 我们把当前时间传进去比较，而不是用 SQL 的 NOW()
    $sql = "SELECT * FROM users 
            WHERE email = :email 
            AND reset_token_hash = :code_hash 
            AND reset_token_expires_at > :current_time";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':code_hash' => $codeHash,
        ':current_time' => $currentProps
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateProfilePicture($id, $profile_picture_url) {
    global $pdo;
    
    $query = "UPDATE users SET profile_picture = :profile_picture WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':profile_picture', $profile_picture_url);
    
    return $stmt->execute();
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


// 1. 保存重置令牌
function setPasswordResetToken($email, $token) {
  global $pdo;

  // 为了安全，数据库存储 Token 的哈希值，而不是明文
  $tokenHash = hash('sha256', $token);
  // 设置过期时间为 1 小时后
  $expiry = date('Y-m-d H:i:s', time() + 60 * 60);

  $sql = "UPDATE users
            SET reset_token_hash = :token_hash,
                reset_token_expires_at = :expiry
            WHERE email = :email";

  $stmt = $pdo->prepare($sql);
  return $stmt->execute([
    ':token_hash' => $tokenHash,
    ':expiry' => $expiry,
    ':email' => $email
  ]);
}

// 2. 根据令牌查找用户（验证令牌是否有效且未过期）
function getUserByResetToken($token) {
  global $pdo;

  $tokenHash = hash('sha256', $token);

  $sql = "SELECT * FROM users
            WHERE reset_token_hash = :token_hash
            AND reset_token_expires_at > NOW()";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([':token_hash' => $tokenHash]);

  return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 3. 重置密码并清空令牌
function resetUserPassword($userId, $newPassword) {
  global $pdo;

  $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

  $sql = "UPDATE users
            SET password = :password,
                reset_token_hash = NULL,
                reset_token_expires_at = NULL
            WHERE id = :id";

  $stmt = $pdo->prepare($sql);
  return $stmt->execute([
    ':password' => $passwordHash,
    ':id' => $userId
  ]);
}
?>
