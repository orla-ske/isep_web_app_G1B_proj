<?php
// 开启错误缓冲区，防止 HTML 泄露干扰 JSON
ob_start();

session_start();
header('Content-Type: application/json');

try {
    // 1. 尝试引入模型 (如果路径错，这里会抛出异常被 catch 捕获)
    $modelPath = __DIR__ . '/../model/Rating.php';
    if (!file_exists($modelPath)) {
        throw new Exception("文件不存在: " . $modelPath);
    }
    require_once $modelPath;

    // 2. 检查类是否存在
    if (!class_exists('RatingModel')) {
        throw new Exception("RatingModel 类未定义。请检查 models/Rating.php");
    }

    // 3. 检查登录
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: User not logged in']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];
        $jobId = $_POST['job_id'] ?? null; 
        $stars = $_POST['stars'] ?? null;
        $feedback = $_POST['feedback'] ?? '';

        if (!$jobId || !$stars) {
            throw new Exception("缺少参数: job_id 或 stars 为空");
        }

        // 4. 尝试执行数据库操作
        if (RatingModel::hasRated($jobId)) {
            echo json_encode(['status' => 'error', 'message' => 'Already rated this job.']);
            exit;
        }

        $result = RatingModel::createRating($userId, $jobId, $stars, $feedback);

        if ($result) {
            // 清除之前的任何输出缓冲，确保只输出 JSON
            ob_clean(); 
            echo json_encode(['status' => 'success', 'message' => 'Rating submitted successfully!']);
        } else {
            throw new Exception("RatingModel::createRating 返回了 false (可能是数据库错误)");
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Request Method']);
    }

} catch (Throwable $e) {
    // 🔥 关键点：捕获所有 PHP 错误（包括 Fatal Error），以 JSON 格式返回
    ob_clean(); // 清除可能已经输出的 HTML 报错
    http_response_code(200); // 强制返回 200，让前端 JS 能解析
    echo json_encode([
        'status' => 'error', 
        'message' => 'PHP Error: ' . $e->getMessage() . ' in ' . basename($e->getFile()) . ' line ' . $e->getLine()
    ]);
}
?>