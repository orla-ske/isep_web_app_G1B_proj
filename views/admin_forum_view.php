<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetStride | Forum Management</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #334155; 
        }
        
        .container { min-height: 100vh; }
        
        .nav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .nav-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo { height: 3rem; }
        .nav-links { display: flex; gap: 2rem; align-items: center; }
        .nav-link {
            color: rgba(0, 0, 0, 0.7);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: #764ba2;
            background: rgba(118, 75, 162, 0.1);
        }
        .admin-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-size: 32px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.5);
            padding: 15px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 800;
            color: #667eea;
        }

        .stat-label {
            font-size: 14px;
            color: #64748B;
            margin-top: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn-create {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .filters {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-select, .filter-input {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            flex: 1;
            max-width: 300px;
        }

        .tabs {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .tab {
            padding: 12px 24px;
            border-radius: 10px;
            background: transparent;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: #64748B;
            transition: all 0.3s;
        }

        .tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .content-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .topic-item, .post-item {
            border-bottom: 1px solid #e2e8f0;
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 20px;
        }

        .topic-item:last-child, .post-item:last-child {
            border-bottom: none;
        }

        .item-content {
            flex: 1;
        }

        .item-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .item-description {
            color: #64748B;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .item-meta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-posts { background: #dbeafe; color: #1e40af; }
        .badge-members { background: #fef3c7; color: #92400e; }
        .badge-comments { background: #e0e7ff; color: #4338ca; }
        .badge-locked { background: #fee2e2; color: #991b1b; }
        .badge-unlocked { background: #dcfce7; color: #166534; }
        .badge-author { background: #f3e8ff; color: #6b21a8; }

        .action-btns {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-view { background: #3b82f6; color: white; }
        .btn-lock { background: #f59e0b; color: white; }
        .btn-unlock { background: #10b981; color: white; }
        .btn-delete { background: #ef4444; color: white; }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 700px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #334155;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
        }

        .message {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .message-success { background: #dcfce7; color: #166534; }
        .message-error { background: #fee2e2; color: #991b1b; }

        .comment-item {
            background: #f8fafc;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .comment-author {
            font-weight: 700;
            color: #1e293b;
        }

        .comment-time {
            font-size: 12px;
            color: #94A3B8;
        }

        .comment-content {
            color: #64748B;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="container">
    <nav class="nav">
        <div class="nav-content">
            <img src="../petstride-logo.png" alt="PetStride" class="nav-logo">
            <div class="nav-links">
                <a href="AdminDashboardController.php" class="nav-link">Dashboard</a>
                <a href="AdminUsersController.php" class="nav-link">Users</a>
                <a href="AdminPetsController.php" class="nav-link">Pets</a>
                <a href="AdminJobsController.php" class="nav-link">Jobs</a>
                <a href="AdminFAQController.php" class="nav-link">FAQ</a>
                <a href="AdminForumController.php" class="nav-link active">Forum</a>
                <a href="AdminReportsController.php" class="nav-link">Reports</a>
                <span class="admin-badge">⚡ Admin</span>
            </div>
        </div>
    </nav>

    <div class="content">
        <div class="page-header">
            <h1 class="page-title">💬 Forum Management</h1>
            <p style="color: #64748B;">Manage forum topics, posts, and comments</p>
            
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['total_topics']; ?></div>
                    <div class="stat-label">Topics</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['total_posts']; ?></div>
                    <div class="stat-label">Posts</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['locked_posts']; ?></div>
                    <div class="stat-label">Locked Posts</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['total_comments']; ?></div>
                    <div class="stat-label">Comments</div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="?create_topic=1" class="btn-create">+ Create Topic</a>
                <a href="?create_post=1" class="btn-create">+ Create Post</a>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message message-<?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Filters -->
        <form method="GET" action="" class="filters">
            <select name="topic" class="filter-select" onchange="this.form.submit()">
                <option value="">All Topics</option>
                <?php foreach ($topics as $topic): ?>
                    <option value="<?php echo $topic['id']; ?>" <?php echo $topicFilter == $topic['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($topic['title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="search" class="filter-input" placeholder="Search posts..." value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
            <button type="submit" class="btn-create">🔍 Search</button>
            <a href="AdminForumController.php" class="btn-create">🔄 Reset</a>
        </form>

        <!-- Topics Section -->
        <div class="content-section">
            <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">📋 Forum Topics</h2>
            <?php if (!empty($topics)): ?>
                <?php foreach ($topics as $topic): ?>
                    <div class="topic-item">
                        <div class="item-content">
                            <div class="item-title"><?php echo htmlspecialchars($topic['title']); ?></div>
                            <?php if ($topic['description']): ?>
                                <div class="item-description"><?php echo htmlspecialchars($topic['description']); ?></div>
                            <?php endif; ?>
                            <div class="item-meta">
                                <span class="badge badge-posts">📝 <?php echo $topic['post_count']; ?> posts</span>
                                <span class="badge badge-members">👥 <?php echo $topic['member_count']; ?> members</span>
                                <?php if ($topic['author_name']): ?>
                                    <span class="badge badge-author">👤 <?php echo htmlspecialchars($topic['author_name']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="action-btns">
                            <button onclick="confirmDeleteTopic(<?php echo $topic['id']; ?>)" class="btn btn-delete">🗑️</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; padding: 40px; color: #94A3B8;">No topics found</p>
            <?php endif; ?>
        </div>

        <!-- Posts Section -->
        <div class="content-section">
            <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">📬 Forum Posts</h2>
            <?php if (!empty($forumPosts)): ?>
                <?php foreach ($forumPosts as $post): ?>
                    <div class="post-item">
                        <div class="item-content">
                            <div class="item-title"><?php echo htmlspecialchars($post['title']); ?></div>
                            <div class="item-description"><?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 200))); ?><?php echo strlen($post['content']) > 200 ? '...' : ''; ?></div>
                            <div class="item-meta">
                                <span class="badge badge-posts">📁 <?php echo htmlspecialchars($post['topic_title']); ?></span>
                                <span class="badge badge-comments">💬 <?php echo $post['comment_count']; ?> comments</span>
                                <span class="badge badge-author">👤 <?php echo htmlspecialchars($post['first_name'] . ' ' . $post['last_name']); ?></span>
                                <?php 
                                $isLocked = $post['is_locked'] === 'yes' || $post['is_locked'] == 1;
                                ?>
                                <span class="badge <?php echo $isLocked ? 'badge-locked' : 'badge-unlocked'; ?>">
                                    <?php echo $isLocked ? '🔒 Locked' : '🔓 Unlocked'; ?>
                                </span>
                                <span class="badge" style="background: #fef3c7; color: #92400e;">
                                    ⏰ <?php echo date('M d, Y', strtotime($post['timestamp'])); ?>
                                </span>
                            </div>
                        </div>
                        <div class="action-btns">
                            <a href="?view=<?php echo $post['id']; ?>" class="btn btn-view">👁️</a>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="toggle_lock">
                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                <input type="hidden" name="current_status" value="<?php echo $post['is_locked']; ?>">
                                <button type="submit" class="btn <?php echo $isLocked ? 'btn-unlock' : 'btn-lock'; ?>">
                                    <?php echo $isLocked ? '🔓' : '🔒'; ?>
                                </button>
                            </form>
                            <button onclick="confirmDeletePost(<?php echo $post['id']; ?>)" class="btn btn-delete">🗑️</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; padding: 40px; color: #94A3B8;">No posts found</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Create Topic Modal -->
<?php if ($showCreateTopic): ?>
<div class="modal active">
    <div class="modal-content">
        <h2 class="modal-title">➕ Create New Topic</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="create_topic">
            
            <div class="form-group">
                <label class="form-label">Topic Title *</label>
                <input type="text" name="title" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea"></textarea>
            </div>
            
            <div class="form-actions">
                <a href="AdminForumController.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Create Topic</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Create Post Modal -->
<?php if ($showCreatePost): ?>
<div class="modal active">
    <div class="modal-content">
        <h2 class="modal-title">➕ Create New Post</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="create_post">
            
            <div class="form-group">
                <label class="form-label">Topic *</label>
                <select name="topic_id" class="form-input" required>
                    <option value="">Select a topic</option>
                    <?php foreach ($topics as $topic): ?>
                        <option value="<?php echo $topic['id']; ?>"><?php echo htmlspecialchars($topic['title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Post Title *</label>
                <input type="text" name="title" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Content *</label>
                <textarea name="content" class="form-textarea" required></textarea>
            </div>
            
            <div class="form-actions">
                <a href="AdminForumController.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Create Post</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- View Post Modal -->
<?php if ($viewPost): ?>
<div class="modal active">
    <div class="modal-content">
        <h2 class="modal-title"><?php echo htmlspecialchars($viewPost['title']); ?></h2>
        <div style="margin-bottom: 20px;">
            <div style="color: #64748B; margin-bottom: 10px;">
                By <?php echo htmlspecialchars($viewPost['author_name']); ?> • 
                <?php echo date('M d, Y H:i', strtotime($viewPost['timestamp'])); ?>
            </div>
            <div style="color: #334155; line-height: 1.6;">
                <?php echo nl2br(htmlspecialchars($viewPost['content'])); ?>
            </div>
        </div>
        
        <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">
        
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 15px;">
            💬 Comments (<?php echo count($postComments); ?>)
        </h3>
        
        <?php if (!empty($postComments)): ?>
            <?php foreach ($postComments as $comment): ?>
                <div class="comment-item">
                    <div class="comment-header">
                        <span class="comment-author"><?php echo htmlspecialchars($comment['author_name']); ?></span>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <span class="comment-time"><?php echo date('M d, H:i', strtotime($comment['timestamp'])); ?></span>
                            <button onclick="confirmDeleteComment(<?php echo $comment['id']; ?>)" class="btn btn-delete" style="padding: 4px 8px; font-size: 10px;">🗑️</button>
                        </div>
                    </div>
                    <div class="comment-content"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; color: #94A3B8; padding: 20px;">No comments yet</p>
        <?php endif; ?>
        
        <div class="form-actions" style="margin-top: 20px;">
            <a href="AdminForumController.php" class="btn-primary">Close</a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Delete Forms -->
<form id="deletePostForm" method="POST" style="display: none;">
    <input type="hidden" name="action" value="delete_post">
    <input type="hidden" name="post_id" id="deletePostId">
</form>

<form id="deleteTopicForm" method="POST" style="display: none;">
    <input type="hidden" name="action" value="delete_topic">
    <input type="hidden" name="topic_id" id="deleteTopicId">
</form>

<form id="deleteCommentForm" method="POST" style="display: none;">
    <input type="hidden" name="action" value="delete_comment">
    <input type="hidden" name="comment_id" id="deleteCommentId">
</form>

<script>
function confirmDeletePost(postId) {
    if (confirm('Are you sure you want to delete this post? This will also delete all comments.')) {
        document.getElementById('deletePostId').value = postId;
        document.getElementById('deletePostForm').submit();
    }
}

function confirmDeleteTopic(topicId) {
    if (confirm('Are you sure you want to delete this topic? This will delete all posts and comments in this topic.')) {
        document.getElementById('deleteTopicId').value = topicId;
        document.getElementById('deleteTopicForm').submit();
    }
}

function confirmDeleteComment(commentId) {
    if (confirm('Are you sure you want to delete this comment?')) {
        document.getElementById('deleteCommentId').value = commentId;
        document.getElementById('deleteCommentForm').submit();
    }
}
</script>

</body>
</html>