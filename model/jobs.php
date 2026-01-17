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

// ✅ FIXED: Include owner_id for chat functionality
function getCaregiverUpcomingJobs($caregiver_id) {
    global $pdo;
    
    $query = "SELECT 
              j.id,
              j.user_id as owner_id,
              j.caregiver_id,
              j.service_type,
              j.start_time,
              j.end_time,
              j.price,
              j.location,
              j.status,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as client_name, 
              u.address, 
              u.phone,
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

// ✅ FIXED: Complete query with all needed fields for messaging
function getOwnerJobs($user_id) {
    global $pdo;
    
    $query = "SELECT 
              j.id,
              j.user_id as owner_id,
              j.caregiver_id,
              j.service_type,
              j.start_time,
              j.end_time,
              j.price,
              j.location,
              j.status,
              p.name as pet_name,
              p.breed,
              p.photo_url,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as caregiver_name, 
              u.phone 
              FROM Job j 
              LEFT JOIN users u ON j.caregiver_id = u.id 
              LEFT JOIN Pet p ON j.pet_id = p.id
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

// ✅ FIXED: Include all fields for display and photo_url
function getOpenJobs($exclude_caregiver_id = null) {
    global $pdo;
    
    $query = "SELECT 
              j.id,
              j.user_id as owner_id,
              j.service_type,
              j.start_time,
              j.end_time,
              j.price,
              j.location,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as owner_name, 
              u.address,
              p.name as pet_name, 
              p.breed,
              p.age,
              p.photo_url
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
              WHERE Job_id IN (
                  SELECT id 
                  FROM Job 
                  WHERE caregiver_id = :user_id
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
              WHERE Job_id IN (
                  SELECT id 
                  FROM Job 
                  WHERE caregiver_id = :user_id
              )";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_reviews'] ?? 0;
}

function getTotalSpent($userId) {
    global $pdo;
    
    $query = "SELECT COALESCE(SUM(price), 0) as total_spent 
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
    
    // Check if job is still open or has no caregiver
    $checkQuery = "SELECT caregiver_id, status FROM Job WHERE id = :job_id";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $checkStmt->execute();
    
    $job = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$job || ($job['caregiver_id'] !== null && $job['status'] === 'Confirmed')) {
        return false;
    }
    
    // Update job with caregiver_id and set to Pending (waiting owner approval)
    $updateQuery = "UPDATE Job SET caregiver_id = :caregiver_id, status = 'Pending' WHERE id = :job_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':caregiver_id', $caregiver_id, PDO::PARAM_INT);
    $updateStmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    
    return $updateStmt->execute();
}

function createJob($user_id, $pet_id, $service_type, $start_time, $end_time, $price, $location = '', $caregiver_id = null) {
    global $pdo;
    
    $status = $caregiver_id ? 'Pending' : 'Open';
    
    $query = "INSERT INTO Job 
              (user_id, pet_id, service_type, start_time, end_time, price, location, status, caregiver_id, payment_id) 
              VALUES 
              (:user_id, :pet_id, :service_type, :start_time, :end_time, :price, :location, :status, :caregiver_id, NULL)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
    $stmt->bindParam(':service_type', $service_type);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':caregiver_id', $caregiver_id, PDO::PARAM_INT);
    
    return $stmt->execute();
}

function declineJobAsCaregiver($job_id) {
    global $pdo;
    
    $query = "UPDATE Job SET caregiver_id = NULL, status = 'Open' WHERE id = :job_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function declineJobAsOwner($job_id) {
    global $pdo;
    
    $query = "UPDATE Job SET caregiver_id = NULL, status = 'Open' WHERE id = :job_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function getJobApplications($owner_id) {
    global $pdo;
    
    $query = "SELECT 
              j.id as job_id,
              j.service_type,
              j.start_time,
              j.price,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as caregiver_name,
              u.id as caregiver_id,
              p.name as pet_name
              FROM Job j
              JOIN users u ON j.caregiver_id = u.id
              JOIN Pet p ON j.pet_id = p.id
              WHERE j.user_id = :owner_id 
              AND j.status = 'Pending'
              ORDER BY j.start_time ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':owner_id', $owner_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>