<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Job #<?php echo htmlspecialchars($job_id); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            overflow: hidden;
            color: #334155;
        }

        /* Background & Animations */
        .container {
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .background {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(242, 242, 242, 0.8) 0%, rgba(113, 154, 252, 0.8) 50%, rgba(242, 242, 242, 0.8) 100%);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
            z-index: -1;
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Floating paws */
        .paw-container {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .paw {
            position: absolute;
            font-size: 60px;
            opacity: 0.1;
            animation: float-paw 20s infinite ease-in-out;
        }

        @keyframes float-paw {
            0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.1; }
            50% { transform: translate(30px, -30px) rotate(180deg); opacity: 0.05; }
        }

        .heart {
            position: absolute;
            animation: floating 3s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .heart-1 { top: 40px; left: 40px; font-size: 48px; opacity: 0.2; }
        .heart-2 { top: 80px; right: 80px; font-size: 64px; opacity: 0.2; animation-delay: 1s; }

        /* Navigation */
        .nav {
            position: relative;
            z-index: 50;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            height: 3rem;
        }

        .back-btn {
            background: rgba(67, 101, 255, 0.1);
            color: #4365ff;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            border: 1px solid rgba(67, 101, 255, 0.2);
        }

        .back-btn:hover {
            background: rgba(67, 101, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Chat Container */
        .chat-wrapper {
            position: relative;
            z-index: 2;
            padding: 20px;
            height: calc(100vh - 80px);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chat-container {
            width: 100%;
            max-width: 900px;
            height: 85vh;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation: scale-in 0.5s ease-out;
        }

        @keyframes scale-in {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }

        .chat-header {
            background: linear-gradient(135deg, rgba(67, 101, 255, 0.9) 0%, rgba(0, 47, 255, 0.9) 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header-left h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .chat-info {
            font-size: 13px;
            opacity: 0.9;
        }

        .chat-messages {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            background: rgba(245, 245, 245, 0.5);
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
            word-wrap: break-word;
        }

        .message.sent .message-bubble {
            background: linear-gradient(135deg, #4365ff 0%, #002fff 100%);
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 4px 15px rgba(67, 101, 255, 0.3);
        }

        .message.received .message-bubble {
            background: rgba(255, 255, 255, 0.9);
            color: #334155;
            border-bottom-left-radius: 4px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .message-sender {
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #4365ff;
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
            color: #64748B;
        }

        .read-status {
            font-size: 10px;
            margin-top: 2px;
            text-align: right;
            opacity: 0.8;
        }

        .chat-input-container {
            padding: 20px 25px;
            background: rgba(255, 255, 255, 0.9);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .input-group {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        textarea {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid rgba(67, 101, 255, 0.2);
            border-radius: 20px;
            font-size: 14px;
            font-family: inherit;
            resize: none;
            height: 50px;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.9);
        }

        textarea:focus {
            outline: none;
            border-color: #4365ff;
            box-shadow: 0 0 0 4px rgba(67, 101, 255, 0.1);
        }

        button {
            padding: 12px 30px;
            background: linear-gradient(135deg, #4365ff 0%, #002fff 100%);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            height: 50px;
            box-shadow: 0 4px 15px rgba(67, 101, 255, 0.3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 101, 255, 0.4);
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .empty-state {
            text-align: center;
            padding: 60px 40px;
            color: #64748B;
        }

        .empty-state p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .chat-messages::-webkit-scrollbar {
            width: 8px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #4365ff;
            border-radius: 4px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #002fff;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="background"></div>
    <div class="paw-container">
        <div class="paw" style="top: 10%; left: 10%;">🐾</div>
        <div class="paw" style="top: 30%; right: 20%; animation-delay: 2s;">🐾</div>
        <div class="paw" style="top: 70%; left: 15%; animation-delay: 4s;">🐾</div>
        <div class="paw" style="top: 50%; right: 10%; animation-delay: 1s;">🐾</div>
    </div>
    <div class="heart heart-1">❤️</div>
    <div class="heart heart-2">💙</div>

    <!-- Navigation -->
    <nav class="nav">
        <div class="nav-content">
            <a href="../views/landingPage.html">
                <img src="../petstride-logo.png" alt="PetStride" class="nav-logo">
            </a>
            <a href="../controller/JobController.php" class="back-btn">← Back to Jobs</a>
        </div>
    </nav>

    <div class="chat-wrapper">
        <div class="chat-container">
            <div class="chat-header">
                <div class="chat-header-left">
                    <h2>💬 Chat for Job #<?php echo htmlspecialchars($job_id); ?></h2>
                    <div class="chat-info">Chatting with <?php echo htmlspecialchars($receiver_name); ?></div>
                </div>
            </div>
            
            <div class="chat-messages" id="chatMessages">
                <?php if (empty($messages)): ?>
                    <div class="empty-state">
                        <p>💬 No messages yet</p>
                        <p style="font-size: 14px; color: #94A3B8;">Start the conversation!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <div class="message <?php echo ($msg['sender_id'] == $current_user_id) ? 'sent' : 'received'; ?>">
                            <div class="message-bubble">
                                <?php if ($msg['sender_id'] != $current_user_id): ?>
                                    <div class="message-sender"><?php echo htmlspecialchars($msg['sender_name']); ?></div>
                                <?php endif; ?>
                                <div class="message-content"><?php echo nl2br(htmlspecialchars($msg['content'])); ?></div>
                                <div class="message-time">
                                    <?php echo date('g:i A', strtotime($msg['timestamp'])); ?>
                                </div>
                                <?php if ($msg['sender_id'] == $current_user_id): ?>
                                    <div class="read-status">
                                        <?php echo ($msg['is_read'] === 'yes') ? '✓✓ Read' : '✓ Sent'; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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
    </div>
</div>

<script>
    const currentUserId = <?php echo $current_user_id; ?>;
    const receiverId = <?php echo $receiver_id; ?>;
    const jobId = <?php echo $job_id; ?>;
    
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
        formData.append('content', content);
        
        fetch(`../controller/ChatController.php?job_id=${jobId}&action=send`, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    document.getElementById('messageInput').value = '';
                    loadMessages();
                } else {
                    alert('Failed to send: ' + (data.error || 'Unknown error'));
                }
            } catch (e) {
                console.error('Invalid JSON response:', text);
                alert('Server error: Invalid response format');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error sending message: ' + error.message);
        })
        .finally(() => {
            sendButton.disabled = false;
            sendButton.textContent = 'Send';
        });
    }
    
    function loadMessages() {
        fetch(`../controller/ChatController.php?job_id=${jobId}&action=get`)
        .then(response => response.json())
        .then(messages => {
            const chatMessages = document.getElementById('chatMessages');
            const wasAtBottom = chatMessages.scrollHeight - chatMessages.scrollTop <= chatMessages.clientHeight + 50;
            
            chatMessages.innerHTML = '';
            
            if (messages.length === 0) {
                chatMessages.innerHTML = '<div class="empty-state"><p>💬 No messages yet</p><p style="font-size: 14px; color: #94A3B8;">Start the conversation!</p></div>';
                return;
            }
            
            messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${msg.sender_id == currentUserId ? 'sent' : 'received'}`;
                
                let senderInfo = '';
                if (msg.sender_id != currentUserId) {
                    senderInfo = `<div class="message-sender">${escapeHtml(msg.sender_name)}</div>`;
                }
                
                let readStatus = '';
                if (msg.sender_id == currentUserId) {
                    readStatus = `<div class="read-status">${msg.is_read === 'yes' ? '✓✓ Read' : '✓ Sent'}</div>`;
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
            
            if (wasAtBottom) {
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
    
    // Auto-refresh every 3 seconds
    setInterval(loadMessages, 3000);
    
    // Send on Enter (Shift+Enter for new line)
    document.getElementById('messageInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
    
    // Scroll to bottom on load
    window.addEventListener('load', function() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
</script>

</body>
</html>