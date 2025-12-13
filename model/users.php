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
        $query = "SELECT * FROM " . $this->table . " WHERE role = 'pet_owner'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
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
