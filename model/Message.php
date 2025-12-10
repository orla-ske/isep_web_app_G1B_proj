<?php
class Message {
    private $pdo;
    private $table = 'messages';

    public $id;
    public $sender_id;
    public $receiver_id;
    public $content;
    public $timestamp;
    public $is_read;
    public $agreement_id;

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Get all messages for a specific agreement
    public function getMessagesByAgreement($agreement_id) {
        $query = "SELECT m.*, 
                  s.name as sender_name, 
                  r.name as receiver_name
                  FROM " . $this->table . " m
                  LEFT JOIN users s ON m.sender_id = s.id
                  LEFT JOIN users r ON m.receiver_id = r.id
                  WHERE m.agreement_id = :agreement_id
                  ORDER BY m.timestamp ASC";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':agreement_id', $agreement_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Get conversation between two users for a specific agreement
    public function getConversation($user1_id, $user2_id, $agreement_id) {
        $query = "SELECT m.*, 
                  s.name as sender_name
                  FROM " . $this->table . " m
                  LEFT JOIN users s ON m.sender_id = s.id
                  WHERE m.agreement_id = :agreement_id
                  AND ((m.sender_id = :user1 AND m.receiver_id = :user2)
                  OR (m.sender_id = :user2 AND m.receiver_id = :user1))
                  ORDER BY m.timestamp ASC";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':agreement_id', $agreement_id, PDO::PARAM_INT);
        $stmt->bindParam(':user1', $user1_id, PDO::PARAM_INT);
        $stmt->bindParam(':user2', $user2_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Create new message
    public function createMessage() {
        $query = "INSERT INTO " . $this->table . " 
                  (sender_id, receiver_id, content, agreement_id, is_read) 
                  VALUES (:sender_id, :receiver_id, :content, :agreement_id, 0)";
        
        $stmt = $this->pdo->prepare($query);
        
        $this->content = htmlspecialchars(strip_tags($this->content));
        
        $stmt->bindParam(':sender_id', $this->sender_id, PDO::PARAM_INT);
        $stmt->bindParam(':receiver_id', $this->receiver_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':agreement_id', $this->agreement_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Mark messages as read
    public function markAsRead($receiver_id, $agreement_id) {
        $query = "UPDATE " . $this->table . " 
                  SET is_read = 1 
                  WHERE receiver_id = :receiver_id 
                  AND agreement_id = :agreement_id 
                  AND is_read = 0";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':receiver_id', $receiver_id, PDO::PARAM_INT);
        $stmt->bindParam(':agreement_id', $agreement_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Get unread message count
    public function getUnreadCount($receiver_id, $agreement_id) {
        $query = "SELECT COUNT(*) as unread_count 
                  FROM " . $this->table . " 
                  WHERE receiver_id = :receiver_id 
                  AND agreement_id = :agreement_id 
                  AND is_read = 0";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':receiver_id', $receiver_id, PDO::PARAM_INT);
        $stmt->bindParam(':agreement_id', $agreement_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result['unread_count'];
    }
}
?>