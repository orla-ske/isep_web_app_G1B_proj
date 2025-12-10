<?php
require_once 'connection.php';

function getAllJobs() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Job");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ✅ FIXED: Uses correct table name 'Job' and schema
function getCaregiverEarnings($caregiver_id) {
    global $pdo;
    
    $query = "SELECT COALESCE(SUM(price), 0) as total 
              FROM Job 
              WHERE caregiver_id = :caregiver_id 
              AND status = 'Completed'";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':caregiver_id', $caregiver_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

// ✅ FIXED: Uses user_id (not owner_id) to match your schema
function getCaregiverUpcomingJobs($caregiver_id) {
    global $pdo;
    
    $query = "SELECT 
              j.id,
              j.service_type,
              j.start_time,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as client_name, 
              u.address, 
              p.name as pet_name, 
              p.breed, 
              p.photo_url
              FROM Job j 
              JOIN users u ON j.user_id = u.id 
              JOIN Pet p ON j.pet_id = p.id
              WHERE j.caregiver_id = :caregiver_id 
              AND (j.status = 'Pending' OR j.status = 'Confirmed' OR j.status IS NULL)
              ORDER BY j.start_time ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':caregiver_id', $caregiver_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ✅ FIXED: Uses user_id to match your schema (user_id is the pet owner)
function getOwnerJobs($user_id) {
    global $pdo;
    
    $query = "SELECT 
              j.service_type,
              j.start_time,
              j.price,
              j.status,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as caregiver_name, 
              u.phone 
              FROM Job j 
              LEFT JOIN users u ON j.caregiver_id = u.id 
              WHERE j.user_id = :user_id 
              ORDER BY j.start_time DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ✅ FIXED: Uses correct table name 'Job'
function updateJobStatus($job_id, $status) {
    global $pdo;
    
    $query = "UPDATE Job 
              SET status = :status 
              WHERE id = :job_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    
    return $stmt->execute();
}
?>