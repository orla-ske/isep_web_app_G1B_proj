<?php
// ============================================================================
// controller/AdminForumController.php
// ============================================================================

session_start();
require_once '../model/connection.php';
require_once '../model/AdminModel.php';
require_once '../model/forum.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: ../login.html");
    exit();
}

$conn = $pdo;

$currentUser = array(
    'id' => $_SESSION['user_id'],
    'first_name' => $_SESSION['first_name'] ?? 'Admin',
    'last_name' => $_SESSION['last_name'] ?? '',
    'role' => $_SESSION['role']
);

// Handle actions
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_topic':
                $title = trim($_POST['title']);
                $description = trim($_POST['description']);
                
                // Use createTopic from forum.php
                if (createTopic($currentUser['id'], $title, $description)) {
                    $message = 'Forum topic created successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to create forum topic.';
                    $messageType = 'error';
                }
                break;
                
            case 'create_post':
                $topicId = intval($_POST['topic_id']);
                $title = trim($_POST['title']);
                $content = trim($_POST['content']);
                
                // Use createPost from forum.php
                if (createPost($currentUser['id'], $topicId, $title, $content)) {
                    $message = 'Forum post created successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to create forum post.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete_post':
                $postId = intval($_POST['post_id']);
                
                // Use deleteForumPost from AdminModel
                if (deleteForumPost($conn, $postId)) {
                    $message = 'Forum post deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to delete forum post.';
                    $messageType = 'error';
                }
                break;
                
            case 'toggle_lock':
                $postId = intval($_POST['post_id']);
                $currentStatus = $_POST['current_status'] ?? 'no';
                $newStatus = ($currentStatus === 'yes') ? 'no' : 'yes';
                
                // Use toggleForumPostLock from AdminModel
                if (toggleForumPostLock($conn, $postId, $newStatus)) {
                    $action = ($newStatus === 'yes') ? 'locked' : 'unlocked';
                    $message = "Forum post $action successfully!";
                    $messageType = 'success';
                } else {
                    $message = 'Failed to update post lock status.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete_topic':
                $topicId = intval($_POST['topic_id']);
                
                try {
                    // First delete all comments in posts of this topic
                    $query = "DELETE FROM ForumComment 
                              WHERE ForumPost_id IN 
                              (SELECT id FROM ForumPost WHERE ForumTopic_id = :topic_id)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':topic_id', $topicId, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    // Then delete all posts in this topic
                    $query = "DELETE FROM ForumPost WHERE ForumTopic_id = :topic_id";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':topic_id', $topicId, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    // Finally delete the topic
                    $query = "DELETE FROM forumTopic WHERE id = :topic_id";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':topic_id', $topicId, PDO::PARAM_INT);
                    
                    if ($stmt->execute()) {
                        $message = 'Forum topic deleted successfully!';
                        $messageType = 'success';
                    } else {
                        $message = 'Failed to delete forum topic.';
                        $messageType = 'error';
                    }
                } catch (PDOException $e) {
                    $message = 'Failed to delete forum topic: ' . $e->getMessage();
                    $messageType = 'error';
                }
                break;
                
            case 'delete_comment':
                $commentId = intval($_POST['comment_id']);
                
                $query = "DELETE FROM ForumComment WHERE id = :id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':id', $commentId, PDO::PARAM_INT);
                
                if ($stmt->execute()) {
                    $message = 'Comment deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to delete comment.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get filters
$topicFilter = isset($_GET['topic']) ? intval($_GET['topic']) : null;
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Get forum data using forum.php functions
$topics = getAllTopics();
$recentPosts = getRecentPosts(50);

// Get forum posts using AdminModel
$forumPosts = getForumPosts($conn, $topicFilter);

// Apply search filter if provided
if (!empty($searchTerm)) {
    $forumPosts = array_filter($forumPosts, function($post) use ($searchTerm) {
        return stripos($post['title'], $searchTerm) !== false ||
               stripos($post['content'], $searchTerm) !== false ||
               stripos($post['first_name'] . ' ' . $post['last_name'], $searchTerm) !== false;
    });
}

// Get statistics
$stats = array(
    'total_topics' => count($topics),
    'total_posts' => count($forumPosts),
    'locked_posts' => count(array_filter($forumPosts, function($post) {
        return $post['is_locked'] === 'yes' || $post['is_locked'] == 1;
    })),
    'total_comments' => array_sum(array_column($forumPosts, 'comment_count'))
);

// Get post details if viewing
$viewPost = null;
$postComments = array();
if (isset($_GET['view'])) {
    $viewPost = getPostById(intval($_GET['view']));
    if ($viewPost) {
        $postComments = getPostComments(intval($_GET['view']));
    }
}

// Show create topic form
$showCreateTopic = isset($_GET['create_topic']);
$showCreatePost = isset($_GET['create_post']);

// Include the view
include '../views/admin_forum_view.php';
?>