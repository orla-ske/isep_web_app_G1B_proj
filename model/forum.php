<?php
require_once 'connection.php';

// Get all forum topics with post count
function getAllTopics() {
    global $pdo;
    
    $query = "SELECT 
              ft.id,
              ft.title,
              ft.description,
              ft.users_id,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as author_name,
              COUNT(DISTINCT fp.id) as post_count,
              (SELECT COUNT(DISTINCT users_id) FROM ForumPost WHERE ForumTopic_id = ft.id) as member_count
              FROM forumTopic ft
              LEFT JOIN users u ON ft.users_id = u.id
              LEFT JOIN ForumPost fp ON ft.id = fp.ForumTopic_id
              GROUP BY ft.id
              ORDER BY ft.id DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get recent forum posts with details
function getRecentPosts($limit = 10) {
    global $pdo;
    
    $query = "SELECT 
              fp.id,
              fp.title,
              fp.content,
              fp.timestamp,
              fp.likes,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as author_name,
              u.id as author_id,
              ft.title as topic_title,
              ft.id as topic_id,
              (SELECT COUNT(*) FROM ForumComment WHERE ForumPost_id = fp.id) as comment_count
              FROM ForumPost fp
              JOIN users u ON fp.Users_id = u.id
              JOIN forumTopic ft ON fp.ForumTopic_id = ft.id
              WHERE fp.is_locked != 'yes' OR fp.is_locked IS NULL
              ORDER BY fp.timestamp DESC
              LIMIT :limit";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Create new forum topic
function createTopic($user_id, $title, $description) {
    global $pdo;
    
    $query = "INSERT INTO forumTopic (title, description, users_id) 
              VALUES (:title, :description, :user_id)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
    return $stmt->execute();
}

// Create new forum post
function createPost($user_id, $topic_id, $title, $content) {
    global $pdo;
    
    $query = "INSERT INTO ForumPost 
              (title, content, timestamp, likes, Users_id, Users_idUsers, ForumTopic_id) 
              VALUES (:title, :content, NOW(), 0, :user_id, :user_id, :topic_id)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
    
    return $stmt->execute();
}

// Get post by ID
function getPostById($post_id) {
    global $pdo;
    
    $query = "SELECT 
              fp.*,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as author_name,
              ft.title as topic_title
              FROM ForumPost fp
              JOIN users u ON fp.Users_id = u.id
              JOIN forumTopic ft ON fp.ForumTopic_id = ft.id
              WHERE fp.id = :post_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get comments for a post
function getPostComments($post_id) {
    global $pdo;
    
    $query = "SELECT 
              fc.*,
              CONCAT(u.first_name, ' ', IFNULL(u.last_name, '')) as author_name
              FROM ForumComment fc
              JOIN users u ON fc.Users_id = u.id
              WHERE fc.ForumPost_id = :post_id
              ORDER BY fc.timestamp ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Create comment
function createComment($user_id, $post_id, $post_user_id, $content) {
    global $pdo;
    
    $query = "INSERT INTO ForumComment 
              (content, timestamp, likes, Users_id, ForumPost_id, ForumPost_Users_idUsers) 
              VALUES (:content, NOW(), 0, :user_id, :post_id, :post_user_id)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':post_user_id', $post_user_id, PDO::PARAM_INT);
    
    return $stmt->execute();
}

// Get category icon based on title keywords
function getCategoryIcon($title) {
    $title_lower = strtolower($title);
    
    if (strpos($title_lower, 'dog') !== false) return '🐕';
    if (strpos($title_lower, 'cat') !== false) return '🐈';
    if (strpos($title_lower, 'health') !== false || strpos($title_lower, 'medical') !== false) return '🏥';
    if (strpos($title_lower, 'photo') !== false || strpos($title_lower, 'picture') !== false) return '📸';
    if (strpos($title_lower, 'training') !== false) return '🎓';
    if (strpos($title_lower, 'food') !== false || strpos($title_lower, 'nutrition') !== false) return '🍖';
    
    return '💬'; // Default icon
}
?>