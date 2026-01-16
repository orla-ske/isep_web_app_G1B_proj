<?php
session_start();
require_once '../model/Message.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.html');
    exit;
}

$current_user_id = $_SESSION['user_id'];

// Handle AJAX requests
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    switch ($_GET['action']) {
        case 'send':
            handleSendMessage($current_user_id);
            break;
        case 'get':
            handleGetMessages($current_user_id);
            break;
        case 'unread':
            handleGetUnreadCount($current_user_id);
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
    exit;
}

// Default: Display chat page
$job_id = $_GET['job_id'] ?? null;

if (!$job_id) {
    header('Location: JobController.php');
    exit;
}

// Get the other participant in this conversation
$otherParticipant = getOtherParticipant($job_id, $current_user_id);

if (!$otherParticipant) {
    die('Job not found or you do not have access to this conversation.');
}

$receiver_id = $otherParticipant['other_user_id'];
$receiver_name = $otherParticipant['other_user_name'];

// Get messages for this conversation
$messages = getJobMessages($job_id, $current_user_id);

// Mark messages as read
markMessagesAsRead($current_user_id, $job_id);

// Get unread count
$unread_count = getUnreadCount($current_user_id, $job_id);

// Load chat view
require_once '../views/chat.php';

// ==================== HELPER FUNCTIONS ====================

function handleSendMessage($sender_id) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        return;
    }
    
    $content = trim($_POST['content'] ?? '');
    $job_id = $_POST['job_id'] ?? null;
    
    if (empty($content) || !$job_id) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        return;
    }
    
    if (sendMessage($sender_id, $job_id, $content)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to send message']);
    }
}

function handleGetMessages($current_user_id) {
    $job_id = $_GET['job_id'] ?? null;
    
    if (!$job_id) {
        echo json_encode(['error' => 'Missing job_id parameter']);
        return;
    }
    
    $messages = getJobMessages($job_id, $current_user_id);
    
    // Mark as read
    markMessagesAsRead($current_user_id, $job_id);
    
    echo json_encode($messages);
}

function handleGetUnreadCount($current_user_id) {
    $job_id = $_GET['job_id'] ?? null;
    
    if (!$job_id) {
        echo json_encode(['error' => 'Missing job_id']);
        return;
    }
    
    $count = getUnreadCount($current_user_id, $job_id);
    echo json_encode(['unread_count' => $count]);
}
?>