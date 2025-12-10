<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Agreement #<?php echo htmlspecialchars($agreement_id); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chat-container {
            width: 90%;
            max-width: 900px;
            height: 90vh;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h2 {
            font-size: 20px;
            font-weight: bold;
        }

        .chat-info {
            font-size: 12px;
            opacity: 0.9;
        }

        .unread-badge {
            background: #ff4757;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f5f5f5;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message.received {
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
        }

        .message.sent .message-bubble {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message.received .message-bubble {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .message-sender {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 4px;
            opacity: 0.8;
        }

        .message.received .message-sender {
            color: #667eea;
        }

        .message-content {
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .message-time {
            font-size: 10px;
            opacity: 0.7;
            text-align: right;
        }

        .message.received .message-time {
            color: #999;
        }

        .read-status {
            font-size: 10px;
            margin-top: 2px;
            text-align: right;
        }

        .chat-input-container {
            padding: 20px;
            background: white;
            border-top: 1px solid #e0e0e0;
        }

        .input-group {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        textarea {
            flex: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 20px;
            font-size: 14px;
            font-family: inherit;
            resize: none;
            height: 50px;
            transition: border-color 0.3s, height 0.2s;
        }

        textarea:focus {
            outline: none;
            border-color: #667eea;
            height: 80px;
        }

        button {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            height: 50px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .chat-messages::-webkit-scrollbar {
            width: 8px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 4px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #764ba2;
        }

        .typing-indicator {
            display: none;
            padding: 10px;
            color: #999;
            font-size: 13px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <div>
                <h2>💬 Agreement Chat #<?php echo htmlspecialchars($agreement_id); ?></h2>
                <div class="chat-info">Chatting with User #<?php echo htmlspecialchars($receiver_id); ?></div>
            </div>
            <div>
                <?php if ($unread_count > 0): ?>
                    <span class="unread-badge"><?php echo $unread_count; ?> unread</span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <?php foreach ($messages as $msg): ?>
                <div class="message <?php echo ($msg['sender_id'] == $current_user_id) ? 'sent' : 'received'; ?>">
                    <div class="message-bubble">
                        <?php if ($msg['sender_id'] != $current_user_id): ?>
                            <div class="message-sender"><?php echo htmlspecialchars($msg['sender_name'] ?? 'User #' . $msg['sender_id']); ?></div>
                        <?php endif; ?>
                        <div class="message-content"><?php echo nl2br(htmlspecialchars($msg['content'])); ?></div>
                        <div class="message-time">
                            <?php echo date('g:i A', strtotime($msg['timestamp'])); ?>
                        </div>
                        <?php if ($msg['sender_id'] == $current_user_id): ?>
                            <div class="read-status">
                                <?php echo $msg['is_read'] ? '✓✓ Read' : '✓ Sent'; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="typing-indicator" id="typingIndicator">
            User is typing...
        </div>
        
        <div class="chat-input-container">
            <div class="input-group">
                <textarea 
                    id="messageInput" 
                    placeholder="Type your message here..."
                    maxlength="1000"
                ></textarea>
                <button onclick="sendMessage()" id="sendButton">Send</button>
            </div>
        </div>
    </div>

    <script>
        const currentUserId = <?php echo $current_user_id; ?>;
        const receiverId = <?php echo $receiver_id; ?>;
        const agreementId = <?php echo $agreement_id; ?>;
        
        function sendMessage() {
            const content = document.getElementById('messageInput').value.trim();
            
            if (!content) {
                alert('Please enter a message');
                return;
            }
            
            const sendButton = document.getElementById('sendButton');
            sendButton.disabled = true;
            sendButton.textContent = 'Sending...';
            
            const formData = new FormData();
            formData.append('receiver_id', receiverId);
            formData.append('content', content);
            formData.append('agreement_id', agreementId);
            
            fetch('controllers/ChatController.php?action=send', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('messageInput').value = '';
                    loadMessages();
                } else {
                    alert('Failed to send message: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error sending message');
            })
            .finally(() => {
                sendButton.disabled = false;
                sendButton.textContent = 'Send';
            });
        }
        
        function loadMessages() {
            fetch(`controllers/ChatController.php?action=get&agreement_id=${agreementId}&receiver_id=${receiverId}`)
            .then(response => response.json())
            .then(messages => {
                if (messages.error) {
                    console.error('Error loading messages:', messages.error);
                    return;
                }
                
                const chatMessages = document.getElementById('chatMessages');
                const scrollAtBottom = chatMessages.scrollHeight - chatMessages.scrollTop <= chatMessages.clientHeight + 50;
                
                chatMessages.innerHTML = '';
                
                messages.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `message ${msg.sender_id == currentUserId ? 'sent' : 'received'}`;
                    
                    let senderInfo = '';
                    if (msg.sender_id != currentUserId) {
                        senderInfo = `<div class="message-sender">${escapeHtml(msg.sender_name || 'User #' + msg.sender_id)}</div>`;
                    }
                    
                    let readStatus = '';
                    if (msg.sender_id == currentUserId) {
                        readStatus = `<div class="read-status">${msg.is_read == 1 ? '✓✓ Read' : '✓ Sent'}</div>`;
                    }
                    
                    messageDiv.innerHTML = `
                        <div class="message-bubble">
                            ${senderInfo}
                            <div class="message-content">${escapeHtml(msg.content).replace(/\n/g, '<br>')}</div>
                            <div class="message-time">${formatTime(msg.timestamp)}</div>
                            ${readStatus}
                        </div>
                    `;
                    chatMessages.appendChild(messageDiv);
                });
                
                if (scrollAtBottom) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            })
            .catch(error => console.error('Error:', error));
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        function formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString('en-US', { 
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
        }
        
        // Auto-refresh messages every 3 seconds
        setInterval(loadMessages, 3000);
        
        // Send message on Enter key (Shift+Enter for new line)
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
        
        // Scroll to bottom on page load
        window.addEventListener('load', function() {
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    </script>
</body>
</html>