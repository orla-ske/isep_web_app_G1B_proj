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
              j.location as address,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as owner_name, 
              p.name as pet_name, 
              p.breed,
              p.age as age
              FROM Job j 
              JOIN users u ON j.user_id = u.id 
              JOIN Pet p ON j.pet_id = p.id
              WHERE j.caregiver_id IS NULL 
              AND j.status = 'Open'
              ORDER BY j.start_time ASC";
    
    $stmt = $pdo->prepare($query);
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

function applyForJob($job_id, $caregiver_id) {
    global $pdo;
    
    // Check if job is still open
    $checkQuery = "SELECT caregiver_id FROM Job WHERE id = :job_id AND caregiver_id IS NULL AND status = 'Open'";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $checkStmt->execute();
    
    if ($checkStmt->rowCount() === 0) {
        // Job is already taken
        return false;
    }
    
    // Update job with caregiver_id
    $updateQuery = "UPDATE Job SET caregiver_id = :caregiver_id, status = 'Pending' WHERE id = :job_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':caregiver_id', $caregiver_id, PDO::PARAM_INT);
    $updateStmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    
    return $updateStmt->execute();
}

function createOpenJob($user_id, $pet_id, $service_type, $start_time, $end_time, $price, $location = '') {
    global $pdo;
    
    $query = "INSERT INTO Job 
              (user_id, pet_id, service_type, start_time, end_time, price, location, status, payment_id) 
              VALUES 
              (:user_id, :pet_id, :service_type, :start_time, :end_time, :price, :location, 'Open', NULL)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
    $stmt->bindParam(':service_type', $service_type);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':location', $location);
    
    return $stmt->execute();
}
?>