<?php
require_once __DIR__ . '/../model/connection.php';

class RatingModel {

    // 1. 创建评价 (改为接收 jobId)
    public static function createRating($userId, $jobId, $stars, $feedback) {
        global $pdo;
        try {
            // SQL 改成了插入 Job_id
            $sql = "INSERT INTO Rating (Users_id, Job_id, Stars, Feedback) 
                    VALUES (:uid, :job_id, :stars, :feedback)";
            
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':uid'      => $userId,
                ':job_id'   => $jobId,     // 对应 Job_id
                ':stars'    => $stars,
                ':feedback' => $feedback
            ]);
        } catch (PDOException $e) {
            return false; 
        }
    }

    // 2. 检查是否已评价 (改为查 Job_id)
    public static function hasRated($jobId) {
        global $pdo;
        $sql = "SELECT id FROM Rating WHERE Job_id = :job_id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':job_id' => $jobId]);
        return $stmt->fetch() ? true : false;
    }
}
?>