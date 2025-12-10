<?php
require_once 'models/Message.php';

class ChatController {
    private $db;
    private $message;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->message = new Message($this->db);
    }

    public function index() {
        // Get agreement_id and receiver_id from URL or session
        $agreement_id = $_GET['agreement_id'] ?? 1;
        $receiver_id = $_GET['receiver_id'] ?? 2;
        $current_user_id = $_SESSION['user_id'];
        
        // Get messages for this conversation
        $messages = $this->message->getConversation($current_user_id, $receiver_id, $agreement_id);
        
        // Mark messages as read
        $this->message->markAsRead($current_user_id, $agreement_id);
        
        // Get unread count
        $unread_count = $this->message->getUnreadCount($current_user_id, $agreement_id);
        
        require_once 'views/chat.php';
    }

    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->message->sender_id = $_SESSION['user_id'];
            $this->message->receiver_id = $_POST['receiver_id'] ?? null;
            $this->message->content = $_POST['content'] ?? '';
            $this->message->agreement_id = $_POST['agreement_id'] ?? null;

            if ($this->message->createMessage()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to send message']);
            }
        }
    }

    public function getMessages() {
        $agreement_id = $_GET['agreement_id'] ?? null;
        $receiver_id = $_GET['receiver_id'] ?? null;
        $current_user_id = $_SESSION['user_id'];
        
        if ($agreement_id && $receiver_id) {
            $messages = $this->message->getConversation($current_user_id, $receiver_id, $agreement_id);
            
            // Mark as read
            $this->message->markAsRead($current_user_id, $agreement_id);
            
            echo json_encode($messages);
        } else {
            echo json_encode(['error' => 'Missing parameters']);
        }
    }

    public function getUnreadCount() {
        $agreement_id = $_GET['agreement_id'] ?? null;
        $current_user_id = $_SESSION['user_id'];
        
        if ($agreement_id) {
            $count = $this->message->getUnreadCount($current_user_id, $agreement_id);
            echo json_encode(['unread_count' => $count]);
        } else {
            echo json_encode(['error' => 'Missing agreement_id']);
        }
    }
}

// AJAX Handler
if (isset($_GET['action'])) {
    $controller = new ChatController();
    
    switch ($_GET['action']) {
        case 'send':
            $controller->sendMessage();
            break;
        case 'get':
            $controller->getMessages();
            break;
        case 'unread':
            $controller->getUnreadCount();
            break;
    }
    exit;
}
?>