<?php
// model/AdminModel.php
require_once '../model/connection.php';
/**
 * Get comprehensive dashboard statistics
 * @param PDO $conn Database connection
 * @return array Statistics data
 */
function getDashboardStats($conn) {
    $stats = array();

    // Get users by role
    $stats['users_by_role'] = getUsersByRole($conn);
    
    // Get total pets
    $stats['total_pets'] = getTotalPets($conn);
    
    // Get jobs by status
    $stats['jobs_by_status'] = getJobsByStatus($conn);
    
    // Get total revenue
    $stats['total_revenue'] = getTotalRevenue($conn);
    
    // Get today's activities (using forum posts as activity indicator)
    $stats['today_activities'] = getTodayActivities($conn);
    
    // Get pending reports (using forum comments count as proxy)
    $stats['pending_reports'] = getPendingReports($conn);

    return $stats;
}

/**
 * Get user counts grouped by role
 * @param PDO $conn Database connection
 * @return array Role => count mapping
 */
function getUsersByRole($conn) {
    $query = "SELECT role, COUNT(*) as count 
              FROM users 
              WHERE role IS NOT NULL
              GROUP BY role";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $roles = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $roles[$row['role']] = (int)$row['count'];
    }
    
    return $roles;
}

/**
 * Get total number of registered pets
 * @param PDO $conn Database connection
 * @return int Total pets count
 */
function getTotalPets($conn) {
    $query = "SELECT COUNT(*) as total FROM Pet";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return (int)($row['total'] ?? 0);
}

/**
 * Get job counts grouped by status
 * @param PDO $conn Database connection
 * @return array Status => count mapping
 */
function getJobsByStatus($conn) {
    $query = "SELECT status, COUNT(*) as count 
              FROM Job 
              WHERE status IS NOT NULL
              GROUP BY status";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $statuses = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $statuses[$row['status']] = (int)$row['count'];
    }
    
    return $statuses;
}

/**
 * Calculate total revenue from jobs with completed payment status
 * @param PDO $conn Database connection
 * @return float Total revenue
 */
function getTotalRevenue($conn) {
    $query = "SELECT COALESCE(SUM(j.price), 0) as total 
              FROM Job j
              WHERE j.payment_status = 1";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return (float)($row['total'] ?? 0);
}

/**
 * Get count of activities from today (forum posts + comments)
 * @param PDO $conn Database connection
 * @return int Today's activity count
 */
function getTodayActivities($conn) {
    $query = "SELECT 
                (SELECT COUNT(*) FROM ForumPost WHERE DATE(timestamp) = CURDATE()) +
                (SELECT COUNT(*) FROM ForumComment WHERE DATE(timestamp) = CURDATE()) +
                (SELECT COUNT(*) FROM Job WHERE DATE(start_time) = CURDATE())
                as total";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return (int)($row['total'] ?? 0);
}

/**
 * Get count of pending items (locked posts or recent messages)
 * @param PDO $conn Database connection
 * @return int Pending reports count
 */
function getPendingReports($conn) {
    $query = "SELECT COUNT(*) as total 
              FROM ForumPost 
              WHERE is_locked = 'yes' OR is_locked = '1'";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return (int)($row['total'] ?? 0);
}

/**
 * Get recent activity logs with user information
 * @param PDO $conn Database connection
 * @param int $limit Number of records to retrieve
 * @return array Recent activity records
 */
function getRecentActivity($conn, $limit = 10) {
    $query = "SELECT 
                'post' as action_type,
                fp.id as target_id,
                'ForumPost' as target_table,
                CONCAT('created a forum post: ', fp.title) as description,
                fp.timestamp,
                u.id as user_id,
                u.first_name,
                u.last_name
              FROM ForumPost fp
              JOIN users u ON fp.Users_id = u.id
              
              UNION ALL
              
              SELECT 
                'comment' as action_type,
                fc.id as target_id,
                'ForumComment' as target_table,
                'commented on a forum post' as description,
                fc.timestamp,
                u.id as user_id,
                u.first_name,
                u.last_name
              FROM ForumComment fc
              JOIN users u ON fc.Users_id = u.id
              
              UNION ALL
              
              SELECT 
                'create' as action_type,
                j.id as target_id,
                'Job' as target_table,
                CONCAT('created a job for ', j.service_type) as description,
                j.start_time as timestamp,
                u.id as user_id,
                u.first_name,
                u.last_name
              FROM Job j
              JOIN users u ON j.user_id = u.id
              
              ORDER BY timestamp DESC
              LIMIT :limit";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all users with pagination
 * @param PDO $conn Database connection
 * @param int $page Current page number
 * @param int $per_page Records per page
 * @return array Users data
 */
function getUsers($conn, $page = 1, $per_page = 20) {
    $offset = ($page - 1) * $per_page;
    
    $query = "SELECT id, first_name, last_name, email, role, phone, created_at, 
                     city, address, postal_code
              FROM users
              ORDER BY created_at DESC
              LIMIT :limit OFFSET :offset";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':limit', $per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get total user count
 * @param PDO $conn Database connection
 * @return int Total users
 */
function getTotalUsers($conn) {
    $query = "SELECT COUNT(*) as total FROM users";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return (int)($row['total'] ?? 0);
}

/**
 * Delete a user by ID
 * @param PDO $conn Database connection
 * @param int $user_id User ID to delete
 * @return bool Success status
 */
function deleteUser($conn, $user_id) {
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $user_id);
    
    return $stmt->execute();
}

// /**
//  * Get user by ID
//  * @param PDO $conn Database connection
//  * @param int $user_id User ID
//  * @return array|null User data
//  */
// function getUserById($conn, $user_id) {
//     $query = "SELECT * FROM users WHERE id = :id";
//     $stmt = $conn->prepare($query);
//     $stmt->bindParam(':id', $user_id);
//     $stmt->execute();
    
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }

// /**
//  * Update user information
//  * @param PDO $conn Database connection
//  * @param int $user_id User ID
//  * @param array $data User data to update
//  * @return bool Success status
//  */
// function updateUser($conn, $user_id, $data) {
//     $fields = array();
//     $params = array(':id' => $user_id);
    
//     foreach ($data as $key => $value) {
//         $fields[] = "$key = :$key";
//         $params[":$key"] = $value;
//     }
    
//     $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
//     $stmt = $conn->prepare($query);
    
//     return $stmt->execute($params);
// }

/**
 * Get all pets with owner information
 * @param PDO $conn Database connection
 * @param int $page Current page number
 * @param int $per_page Records per page
 * @return array Pets data
 */
function getPets($conn, $page = 1, $per_page = 20) {
    $offset = ($page - 1) * $per_page;
    
    $query = "SELECT 
                p.*,
                u.first_name as owner_first_name,
                u.last_name as owner_last_name,
                u.email as owner_email,
                u.phone as owner_phone
              FROM Pet p
              LEFT JOIN users u ON p.Users_id = u.id
              ORDER BY p.id DESC
              LIMIT :limit OFFSET :offset";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':limit', $per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get pet by ID
 * @param PDO $conn Database connection
 * @param int $pet_id Pet ID
 * @return array|null Pet data
 */
function getPetById($conn, $pet_id) {
    $query = "SELECT p.*, u.first_name, u.last_name, u.email
              FROM Pet p
              LEFT JOIN users u ON p.Users_id = u.id
              WHERE p.id = :id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $pet_id);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Delete a pet by ID
 * @param PDO $conn Database connection
 * @param int $pet_id Pet ID to delete
 * @return bool Success status
 */
function deletePet($conn, $pet_id) {
    $query = "DELETE FROM Pet WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $pet_id);
    
    return $stmt->execute();
}

/**
 * Get all jobs with related information
 * @param PDO $conn Database connection
 * @param int $page Current page number
 * @param int $per_page Records per page
 * @return array Jobs data
 */
function getJobs($conn, $page = 1, $per_page = 20) {
    $offset = ($page - 1) * $per_page;
    
    $query = "SELECT 
                j.*,
                owner.first_name as owner_first_name,
                owner.last_name as owner_last_name,
                owner.email as owner_email,
                caregiver.first_name as caregiver_first_name,
                caregiver.last_name as caregiver_last_name,
                p.amount as payment_amount,
                p.method as payment_method
              FROM Job j
              LEFT JOIN users owner ON j.user_id = owner.id
              LEFT JOIN users caregiver ON j.caregiver_id = caregiver.id
              LEFT JOIN Payment p ON j.Payment_id = p.id
              ORDER BY j.start_time DESC
              LIMIT :limit OFFSET :offset";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':limit', $per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get job by ID
 * @param PDO $conn Database connection
 * @param int $job_id Job ID
 * @return array|null Job data
 */
function getJobById($conn, $job_id) {
    $query = "SELECT j.*, 
                     owner.first_name as owner_first_name,
                     owner.last_name as owner_last_name,
                     caregiver.first_name as caregiver_first_name,
                     caregiver.last_name as caregiver_last_name
              FROM Job j
              LEFT JOIN users owner ON j.user_id = owner.id
              LEFT JOIN users caregiver ON j.caregiver_id = caregiver.id
              WHERE j.id = :id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $job_id);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Update job status
 * @param PDO $conn Database connection
 * @param int $job_id Job ID
 * @param string $status New status
 * @return bool Success status
 */
function updateJobStatus($conn, $job_id, $status) {
    $query = "UPDATE Job 
              SET status = :status 
              WHERE id = :id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $job_id);
    
    return $stmt->execute();
}

/**
 * Delete a job by ID
 * @param PDO $conn Database connection
 * @param int $job_id Job ID to delete
 * @return bool Success status
 */
function deleteJob($conn, $job_id) {
    $query = "DELETE FROM Job WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $job_id);
    
    return $stmt->execute();
}

/**
 * Get all forum topics with user information
 * @param PDO $conn Database connection
 * @return array Forum topics data
 */
function getForumTopics($conn) {
    $query = "SELECT 
                ft.*,
                u.first_name,
                u.last_name,
                (SELECT COUNT(*) FROM ForumPost WHERE ForumTopic_id = ft.id) as post_count
              FROM forumTopic ft
              LEFT JOIN users u ON ft.users_id = u.id
              ORDER BY ft.id DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all forum posts with topic and user information
 * @param PDO $conn Database connection
 * @param int $topic_id Optional topic ID filter
 * @return array Forum posts data
 */
function getForumPosts($conn, $topic_id = null) {
    $query = "SELECT 
                fp.*,
                u.first_name,
                u.last_name,
                ft.title as topic_title,
                (SELECT COUNT(*) FROM ForumComment WHERE ForumPost_id = fp.id) as comment_count
              FROM ForumPost fp
              LEFT JOIN users u ON fp.Users_id = u.id
              LEFT JOIN forumTopic ft ON fp.ForumTopic_id = ft.id";
    
    if ($topic_id) {
        $query .= " WHERE fp.ForumTopic_id = :topic_id";
    }
    
    $query .= " ORDER BY fp.timestamp DESC";
    
    $stmt = $conn->prepare($query);
    
    if ($topic_id) {
        $stmt->bindParam(':topic_id', $topic_id);
    }
    
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Delete forum post
 * @param PDO $conn Database connection
 * @param int $post_id Post ID
 * @return bool Success status
 */
function deleteForumPost($conn, $post_id) {
    $query = "DELETE FROM ForumPost WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $post_id);
    
    return $stmt->execute();
}

/**
 * Toggle forum post lock status
 * @param PDO $conn Database connection
 * @param int $post_id Post ID
 * @param string $status Lock status (yes/no)
 * @return bool Success status
 */
function toggleForumPostLock($conn, $post_id, $status) {
    $query = "UPDATE ForumPost SET is_locked = :status WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $post_id);
    
    return $stmt->execute();
}

/**
 * Get all ratings with user and job information
 * @param PDO $conn Database connection
 * @return array Ratings data
 */
function getRatings($conn) {
    $query = "SELECT 
                r.*,
                u.first_name,
                u.last_name,
                ja.title as agreement_title
              FROM Rating r
              LEFT JOIN users u ON r.Users_id = u.id
              LEFT JOIN Job_Agreement ja ON r.Job_Agreement_id = ja.id
              ORDER BY r.id DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get messages with sender and receiver information
 * @param PDO $conn Database connection
 * @param int $limit Number of records to retrieve
 * @return array Messages data
 */
function getMessages($conn, $limit = 50) {
    $query = "SELECT 
                m.*,
                sender.first_name as sender_first_name,
                sender.last_name as sender_last_name,
                receiver.first_name as receiver_first_name,
                receiver.last_name as receiver_last_name
              FROM Message m
              LEFT JOIN users sender ON m.sender_id = sender.id
              LEFT JOIN users receiver ON m.reciever_id = receiver.id
              ORDER BY m.timestamp DESC
              LIMIT :limit";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>