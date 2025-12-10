<?php
    include 'connection.php';

    function getAllJobs() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM Job");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCaregiverEarnings($caregiver_id) {
        $query = "SELECT SUM(price) as total 
                  FROM " . $this->table . " 
                  WHERE caregiver_id = :caregiver_id 
                  AND status = 'Completed'";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':caregiver_id', $caregiver_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    function getCaregiverUpcomingJobs($caregiver_id) {
        $query = "SELECT j.*, 
                  u.first_name as client_name, 
                  u.address, 
                  p.name as pet_name, 
                  p.breed, 
                  p.photo_url
                  FROM " . $this->table . " j 
                  JOIN users u ON j.user_id = u.id 
                  LEFT JOIN Pet p ON j.pet_id = p.id
                  WHERE j.caregiver_id = :caregiver_id 
                  AND j.status != 'Completed'
                  ORDER BY j.start_time ASC";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':caregiver_id', $caregiver_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    function getOwnerJobs($user_id) {
        $query = "SELECT j.*, 
                  u.first_name as caregiver_name, 
                  u.phone 
                  FROM " . $this->table . " j 
                  JOIN users u ON j.caregiver_id = u.id 
                  WHERE j.user_id = :user_id 
                  ORDER BY j.start_time DESC";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    function updateJobStatus($job_id, $status) {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status 
                  WHERE id = :job_id";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
?>