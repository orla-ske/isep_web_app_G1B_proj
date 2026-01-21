<?php
// 1. 禁止 PHP 将错误信息直接打印到页面上，防止破坏 JSON 格式
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

// 引入模型
require_once '../model/users.php';

// 引入 PHPMailer (放在这里方便复用)
require_once '../model/PHPMailer/Exception.php';
require_once '../model/PHPMailer/PHPMailer.php';
require_once '../model/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['status' => 'error', 'message' => 'An unexpected error occurred.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'] ?? '';

    // 获取并清洗 Email
    $rawEmail = $_POST['email'] ?? '';
    $email = filter_var(trim($rawEmail), FILTER_SANITIZE_EMAIL);

    // 获取密码
    $password = $_POST['password'] ?? '';

    // 获取验证码 (新增)
    $code = $_POST['code'] ?? '';

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
        $role = $_POST['role'] ?? 'pet_owner';

        if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            exit;
        }

        if (getUserByEmail($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
            exit;
        }

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

    // --- FORGOT PASSWORD (发送验证码) ---
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

        // 🔥 修改 1: 生成 6 位随机数字，而不是长 Token
        $verificationCode = (string)rand(100000, 999999);

        // 存入数据库 (Model 会自动 hash 它)
        if (setPasswordResetToken($email, $verificationCode)) {

            $mail = new PHPMailer(true);

            try {
                // 配置服务器
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;

                // ⚠️ 建议把这里的密码移到配置文件中，不要硬编码
                $mail->Username   = 'vc382936@gmail.com';
                $mail->Password   = '';

                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('vc382936@gmail.com', 'PetStride Security');
                $mail->addAddress($email);

                // 🔥 修改 2: 发送验证码邮件
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Code - PetStride';
                $mail->Body    = "
                    <div style='font-family: Arial, sans-serif; padding: 20px; color: #333;'>
                        <h2>Password Reset Request</h2>
                        <p>Your verification code is:</p>
                        <h1 style='color: #4A9FD8; letter-spacing: 5px; font-size: 32px;'>$verificationCode</h1>
                        <p>This code expires in 1 hour.</p>
                        <p>If you did not request this, please ignore this email.</p>
                    </div>
                ";
                $mail->AltBody = "Your verification code is: $verificationCode";

                $mail->send();

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Verification code sent to your email!',
                    'redirect_email' => $email // 把邮箱传回前端，方便带到下一个页面
                ]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Mail Error: ' . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error.']);
        }
    }

    // --- RESET PASSWORD (验证码 + 新密码) ---
    elseif ($action === 'reset_password') {
        // 🔥 修改 3: 这里需要 Email + Code + Password
        // $email 已经在最上面获取了
        // $code 已经在最上面获取了
        // $password 已经在最上面获取了

        if (empty($email) || empty($code) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing email, code or password.']);
            exit;
        }

        // 验证 邮箱 + 验证码
        // ⚠️ 确保你的 models/users.php 里已经添加了 verifyUserByCode 函数！
        $user = verifyUserByCode($email, $code);

        if ($user) {
            // 更新密码
            if (resetUserPassword($user['id'], $password)) {
                echo json_encode(['status' => 'success', 'message' => 'Password reset successful! Please login.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update password.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid or expired verification code.']);
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
