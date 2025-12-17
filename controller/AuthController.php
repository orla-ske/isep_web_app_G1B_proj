<?php
session_start();
header('Content-Type: application/json'); // Return JSON for the JS frontend

// Include your existing user logic
require_once '../model/users.php';

$response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get raw POST data
    $action = $_POST['action'] ?? '';
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // --- LOGIN LOGIC ---
    if ($action === 'login') {
        if (empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
            exit;
        }

        $user = getUserByEmail($email);

        if ($user && verifyPassword($password, $user['password'])) {
            // Set Session Variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['firstname'] = $user['first_name'];
            $_SESSION['role'] = $user['role'];

            echo json_encode(['status' => 'success', 'message' => 'Login successful! Redirecting...']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        }
    }

    // --- SIGNUP LOGIC ---
    elseif ($action === 'signup') {
        $firstname = trim($_POST['firstName'] ?? '');
        $lastname = trim($_POST['lastName'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'];

        // check if user exists
        if (getUserByEmail($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
            exit;
        }


        // Attempt to create user
        if (createUser($firstname, $lastname, $email, $password, $role)) {
            // Optional: Auto-login after signup
            $newUser = getUserByEmail($email);
            $_SESSION['user_id'] = $newUser['id'];

            echo json_encode(['status' => 'success', 'message' => 'Account created! Redirecting...']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again.']);
        }
    }

  // --- FORGOT PASSWORD (请求重置) ---
  // --- FORGOT PASSWORD ---
elseif ($action === 'forgot_password') {
    if (empty($email)) {
      echo json_encode(['status' => 'error', 'message' => 'Please enter your email address.']);
      exit;
    }

    // if user exists
    $user = getUserByEmail($email);
    if (!$user) {
      // 为了安全，通常不告诉用户邮箱不存在，但为了调试方便先返回错误
      echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
      exit;
    }

    // random Token
    $token = bin2hex(random_bytes(16));

    // save to database
    if (setPasswordResetToken($email, $token)) {
      // 1. 自动获取当前的主机和端口 (例如 localhost:63342)
      $host = $_SERVER['HTTP_HOST'];

// 2. 自动获取当前脚本所在的目录 (例如 /project/controllers)
      $currentDir = dirname($_SERVER['PHP_SELF']);

// 3. 计算出根目录 (例如 /project) - 即往上退一级
      $rootDir = dirname($currentDir);

// 4. 拼接出正确的重置链接
      $resetLink = "http://" . $host . $rootDir . "/views/reset_password.php?token=" . $token;

      echo json_encode([
        'status' => 'success',
        'message' => 'Reset link generated! (Check console or alert)',
        'debug_link' => $resetLink // 前端拿到这个链接跳转
      ]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
  }


  // --- RESET PASSWORD (执行重置) ---
  elseif ($action === 'reset_password') {
    $token = $_POST['token'] ?? '';
    $newPassword = $_POST['password'] ?? '';

    if (empty($token) || empty($newPassword)) {
      echo json_encode(['status' => 'error', 'message' => 'Missing token or password.']);
      exit;
    }

    // verify Token
    $user = getUserByResetToken($token);

    if ($user) {
      // update password
      if (resetUserPassword($user['id'], $newPassword)) {
        echo json_encode(['status' => 'success', 'message' => 'Password has been reset! Please login.']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update password.']);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Invalid or expired token.']);
    }
  }
    else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}


?>
