<?php
session_start();
require_once '../model/connection.php';
require_once '../model/forum.php';

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;
$user_name = $is_logged_in ? ($_SESSION['user_name'] ?? 'User') : null;

$errors = [];
$success_message = '';

// Handle post creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_post'])) {
    if (!$is_logged_in) {
        $errors[] = "You must be logged in to create a post";
    } else {
        $topic_id = $_POST['topic_id'] ?? null;
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        
        if (empty($title)) $errors[] = "Post title is required";
        if (empty($content)) $errors[] = "Post content is required";
        if (empty($topic_id)) $errors[] = "Please select a topic";
        
        if (empty($errors)) {
            if (createPost($user_id, $topic_id, $title, $content)) {
                $success_message = "Post created successfully!";
            } else {
                $errors[] = "Failed to create post. Please try again.";
            }
        }
    }
}

// Handle topic creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_topic'])) {
    if (!$is_logged_in) {
        $errors[] = "You must be logged in to create a topic";
    } else {
        $title = trim($_POST['topic_title'] ?? '');
        $description = trim($_POST['topic_description'] ?? '');
        
        if (empty($title)) $errors[] = "Topic title is required";
        if (empty($description)) $errors[] = "Topic description is required";
        
        if (empty($errors)) {
            if (createTopic($user_id, $title, $description)) {
                $success_message = "Topic created successfully!";
            } else {
                $errors[] = "Failed to create topic. Please try again.";
            }
        }
    }
}

// Fetch data
$topics = getAllTopics();
$recent_posts = getRecentPosts(10);

// Load the view
require_once '../views/forum.php';
?>