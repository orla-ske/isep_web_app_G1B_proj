<?php
session_start();
require_once '../models/connection.php';
require_once '../models/ForumModel.php';

$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

$post_id = $_GET['id'] ?? null;
$errors = [];
$success_message = '';

if (!$post_id) {
    header('Location: ForumController.php');
    exit;
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_comment'])) {
    if (!$is_logged_in) {
        $errors[] = "You must be logged in to comment";
    } else {
        $content = trim($_POST['comment_content'] ?? '');
        
        if (empty($content)) {
            $errors[] = "Comment cannot be empty";
        } else {
            $post = getPostById($post_id);
            if (createComment($user_id, $post_id, $post['Users_id'], $content)) {
                $success_message = "Comment added successfully!";
            } else {
                $errors[] = "Failed to add comment";
            }
        }
    }
}

// Get post and comments
$post = getPostById($post_id);
$comments = getPostComments($post_id);

if (!$post) {
    die("Post not found");
}

require_once '../views/postDetail.php';
?>