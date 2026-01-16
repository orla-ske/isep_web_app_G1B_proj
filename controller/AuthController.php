<?php
// 1. 禁止 PHP 将错误信息直接打印到页面上，防止破坏 JSON 格式
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json'); // 告诉前端返回的是 JSON

// 引入模型 (请确保路径正确，如果是 models 文件夹请自行修改为 ../models/users.php)
require_once '../model/users.php';

$response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 获取 action，如果没有则为空
    $action = $_POST['action'] ?? '';

    // 🔥 关键修复：这里使用 ?? '' 防止在 reset_password 时报错 "Undefined array key email"
    $rawEmail = $_POST['email'] ?? '';
    $email = filter_var(trim($rawEmail), FILTER_SANITIZE_EMAIL);

    // 获取密码，如果没有则为空
    $password = $_POST['password'] ?? '';

    // --- LOGIN LOGIC ---
    if ($action === 'login') {
        if (empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
            exit;
        }

        $user = getUserByEmail($email);

        if ($user && verifyPassword($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['firstname'] = $user['first_name']; // 确保数据库字段名是 first_name
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
        // $email 已经在上面获取了
        // $password 已经在上面获取了
        $role = $_POST['role'] ?? 'pet_owner'; // 默认角色

        // 验证必填项
        if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            exit;
        }

        // check if user exists
        if (getUserByEmail($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
            exit;
        }

        // Attempt to create user
        if (createUser($firstname, $lastname, $email, $password, $role)) {
            $newUser = getUserByEmail($email);
            $_SESSION['user_id'] = $newUser['id'];
            $_SESSION['role'] = $newUser['role'];
            $_SESSION['firstname'] = $newUser['first_name'];

            echo json_encode(['status' => 'success', 'message' => 'Account created! Redirecting...']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again.']);
        }
    }

    // --- FORGOT PASSWORD ---
    elseif ($action === 'forgot_password') {
        if (empty($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Please enter your email address.']);
            exit;
        }

        $user = getUserByEmail($email);
        if (!$user) {
            echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
            exit;
        }

        $token = bin2hex(random_bytes(16));

        if (setPasswordResetToken($email, $token)) {
            // 1. 生成链接
            $host = $_SERVER['HTTP_HOST'];
            $currentDir = dirname($_SERVER['PHP_SELF']);
            $rootDir = dirname($currentDir);
            $resetLink = "http://" . $host . $rootDir . "/views/reset_password.php?token=" . $token;

            // 2. 引入 PHPMailer (注意路径要对！)
            require_once '../model/PHPMailer/Exception.php';
            require_once '../model/PHPMailer/PHPMailer.php';
            require_once '../model/PHPMailer/SMTP.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            try {
                // 配置服务器
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'vc382936@gmail.com'; // 🟢 改这里
                $mail->Password   = 'gdwymyjdtwcknpvu';     // 🟢 改这里
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                // 收发件人
                $mail->setFrom('vc382936@gmail.com', 'petstride'); // 🟢 改这里
                $mail->addAddress($email);

                // 内容
                $mail->isHTML(true);
                $mail->Subject = 'Reset Password - PetStride';
                $mail->Body    = "Click here to reset: <a href='$resetLink'>$resetLink</a>";

                $mail->send();

                echo json_encode(['status' => 'success', 'message' => 'Email sent! Please check your inbox.']);
            } catch (Exception $e) {
                // 发送失败返回错误
                echo json_encode(['status' => 'error', 'message' => 'Mail Error: ' . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error.']);
        }
    }
    // --- RESET PASSWORD (执行重置) ---
    elseif ($action === 'reset_password') {
        // 这里不需要 email，所以上面那个修复至关重要
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

    // --- INVALID ACTION ---
    else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action: ' . htmlspecialchars($action)]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>