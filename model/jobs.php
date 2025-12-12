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

function getOpenJobs($exclude_caregiver_id) {
    global $pdo;
    
    $query = "SELECT 
              j.id,
              j.service_type,
              j.start_time,
              j.price,
              j.location,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as owner_name, 
              p.name as pet_name, 
              p.breed,
              p.age,
              p.photo_url
              FROM Job j 
              JOIN users u ON j.user_id = u.id 
              JOIN Pet p ON j.pet_id = p.id
              WHERE j.caregiver_id IS NULL 
              AND j.user_id != :exclude_caregiver_id
              ORDER BY j.start_time ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':exclude_caregiver_id', $exclude_caregiver_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchOpenJobs($exclude_caregiver_id, $searchTerm) {
    global $pdo;
    
    $searchTerm = "%$searchTerm%";
    
    $query = "SELECT 
              j.id,
              j.service_type,
              j.start_time,
              j.price,
              j.location,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as owner_name, 
              p.name as pet_name, 
              p.breed,
              p.age,
              p.photo_url
              FROM Job j 
              JOIN users u ON j.user_id = u.id 
              JOIN Pet p ON j.pet_id = p.id
              WHERE j.caregiver_id IS NULL 
              AND j.user_id != :exclude_caregiver_id
              AND (
                  j.location LIKE :search 
                  OR j.service_type LIKE :search 
                  OR p.breed LIKE :search
              )
              ORDER BY j.start_time ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':exclude_caregiver_id', $exclude_caregiver_id, PDO::PARAM_INT);
    $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAverageRating($userId) {
    global $pdo;
    
    $query = "SELECT AVG(Stars) as avg_rating 
              FROM Rating 
              WHERE Job_Agreement_id IN (
                  SELECT id 
                  FROM Job_Agreement 
                  WHERE Users_id = :user_id
              )";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['avg_rating'] ?? 0;
}

function getTotalReviews($userId) {
    global $pdo;
    
    $query = "SELECT COUNT(*) as total_reviews 
              FROM Rating 
              WHERE Job_Agreement_id IN (
                  SELECT id 
                  FROM Job_Agreement 
                  WHERE Users_id = :user_id
              )";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_reviews'] ?? 0;
}

function getTotalSpent($userId) {
    global $pdo;
    
    $query = "SELECT SUM(price) as total_spent 
              FROM Job 
              WHERE user_id = :user_id 
              AND status = 'Completed'";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_spent'] ?? 0;
}


function getCompletedJobsCount($userId) {
    global $pdo;
    
    $query = "SELECT COUNT(*) as completed_jobs 
              FROM Job 
              WHERE user_id = :user_id 
              AND status = 'Completed'";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['completed_jobs'] ?? 0;
}
?>