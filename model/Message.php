<?php
require_once 'connection.php';

// Get conversation between two users for a specific job
function getJobMessages($job_id, $user_id) {
    global $pdo;
    
    // First get the job details to find the other participant
    $jobQuery = "SELECT user_id, caregiver_id FROM Job WHERE id = :job_id";
    $stmt = $pdo->prepare($jobQuery);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->execute();
    $job = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$job) return [];
    
    // Determine the other user
    $other_user_id = ($job['user_id'] == $user_id) ? $job['caregiver_id'] : $job['user_id'];
    
    $query = "SELECT m.*, 
              CONCAT(s.first_name, ' ', IFNULL(s.last_name, '')) as sender_name
              FROM Message m
              LEFT JOIN users s ON m.sender_id = s.id
              WHERE m.job_id = :job_id
              AND ((m.sender_id = :user1 AND m.reciever_id = :user2)
              OR (m.sender_id = :user2 AND m.reciever_id = :user1))
              ORDER BY m.timestamp ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->bindParam(':user1', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':user2', $other_user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Send a message
function sendMessage($sender_id, $job_id, $content) {
    global $pdo;

    // Sanitize message content
    $content = htmlspecialchars(strip_tags($content), ENT_QUOTES, 'UTF-8');

    // 1. Get both IDs from the Job to determine the correct receiver
    // This allows the pet owner to message the caregiver OR vice versa.
    $jobQuery = "
        SELECT owner_id, caregiver_id
        FROM Job
        WHERE id = :job_id
        LIMIT 1
    ";

    $jobStmt = $pdo->prepare($jobQuery);
    $jobStmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $jobStmt->execute();

    $job = $jobStmt->fetch(PDO::FETCH_ASSOC);

    // Job not found or caregiver not yet assigned
    if (!$job || empty($job['caregiver_id'])) {
        return false;
    }

    // Identify the receiver: If sender is owner, receiver is caregiver (and vice versa)
    $receiver_id = ($sender_id == $job['owner_id']) ? $job['caregiver_id'] : $job['owner_id'];

    // 2. Insert message
    $query = "
        INSERT INTO Message 
        (sender_id, receiver_id, content, job_id, timestamp, is_read) 
        VALUES (:sender_id, :receiver_id, :content, :job_id, NOW(), 'no')
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':sender_id', $sender_id, PDO::PARAM_INT);
    $stmt->bindParam(':receiver_id', $receiver_id, PDO::PARAM_INT);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);

    return $stmt->execute();
}


// Mark messages as read
function markMessagesAsRead($user_id, $job_id) {
    global $pdo;
    
    $query = "UPDATE Message 
              SET is_read = 'yes' 
              WHERE reciever_id = :user_id 
              AND job_id = :job_id 
              AND is_read = 'no'";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    
    return $stmt->execute();
}

// Get unread count for a job
function getUnreadCount($user_id, $job_id) {
    global $pdo;
    
    $query = "SELECT COUNT(*) as count 
              FROM Message 
              WHERE reciever_id = :user_id 
              AND job_id = :job_id 
              AND is_read = 'no'";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] ?? 0;
}

// Get other participant in job chat
function getOtherParticipant($job_id, $current_user_id) {
    global $pdo;
    
    $query = "SELECT 
              CASE 
                WHEN user_id = :user_id THEN caregiver_id
                ELSE user_id
              END as other_user_id,
              CASE 
                WHEN user_id = :user_id THEN 
                    (SELECT CONCAT(first_name, ' ', IFNULL(last_name, '')) FROM users WHERE id = caregiver_id)
                ELSE 
                    (SELECT CONCAT(first_name, ' ', IFNULL(last_name, '')) FROM users WHERE id = user_id)
              END as other_user_name
              FROM Job 
              WHERE id = :job_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $current_user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>