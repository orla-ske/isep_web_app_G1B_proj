<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Forum - PetStride</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        .container {
            min-height: 100vh;
            position: relative;
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

        .paw-container {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .paw {
            position: absolute;
            font-size: 2rem;
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }

        .paw-1 { top: 20%; left: 10%; }
        .paw-2 { top: 60%; right: 15%; animation-delay: 5s; }
        .paw-3 { bottom: 20%; left: 20%; animation-delay: 10s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        /* Navigation */
        .nav {
            position: sticky;
            top: 0;
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
            height: 2.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: rgba(0, 0, 0, 0.7);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #764ba2;
        }

        .login-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
        }

        /* Hero Section */
        .content {
            position: relative;
            z-index: 1;
            padding: 2rem 1rem;
        }

        .hero {
            max-width: 56rem;
            margin: 0 auto 3rem;
            text-align: center;
            padding: 3rem 1rem;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(51, 51, 51, 0.8);
            margin-bottom: 2rem;
        }

        .create-post-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.2s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .create-post-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .create-post-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Alerts */
        .alert {
            max-width: 72rem;
            margin: 0 auto 2rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 500;
        }

        .alert-error {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert ul {
            margin-left: 20px;
            margin-top: 5px;
        }

        /* Forum Container */
        .forum-container {
            max-width: 72rem;
            margin: 0 auto;
            padding: 0 1rem 3rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1.5rem;
        }

        /* Categories */
        .categories-section {
            margin-bottom: 3rem;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .category-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .category-card:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .category-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .category-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .category-description {
            font-size: 0.875rem;
            color: #666;
            line-height: 1.5;
        }

        .category-stats {
            margin-top: 1rem;
            font-size: 0.75rem;
            color: #999;
        }

        /* Posts */
        .posts-section {
            margin-bottom: 3rem;
        }

        .posts-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .post-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            text-decoration: none;
            display: block;
            color: inherit;
        }

        .post-card:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .post-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .post-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .post-author-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .post-author {
            font-weight: 600;
            color: #333;
            font-size: 1rem;
        }

        .post-time {
            font-size: 0.875rem;
            color: #999;
        }

        .post-category-tag {
            padding: 0.25rem 0.75rem;
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 12px;
            font-size: 0.75rem;
            color: #667eea;
            font-weight: 500;
        }

        .post-content {
            margin-bottom: 1rem;
        }

        .post-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .post-excerpt {
            color: #666;
            line-height: 1.6;
        }

        .post-footer {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .post-stat {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #999;
            font-size: 0.875rem;
        }

        .post-stat svg {
            width: 18px;
            height: 18px;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: #764ba2;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem;
            color: #999;
            font-size: 0.875rem;
        }

        .footer-link {
            color: #999;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-link:hover {
            color: #333;
        }

        .footer-dot {
            margin: 0 0.5rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }

            .post-header {
                flex-direction: column;
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="background"></div>
        
        <div class="paw-container">
            <div class="paw paw-1">🐾</div>
            <div class="paw paw-2">🐾</div>
            <div class="paw paw-3">🐾</div>
        </div>

        <!-- Navigation -->
        <nav class="nav">
            <div class="nav-content">
                <a href="../landingPage.html">
                    <img src="../petstride-logo.png" alt="PetStride" class="nav-logo">
                </a>
                <div class="nav-links">
                    <a href="../landingPage.html" class="nav-link">Home</a>
                    <a href="../faq.html" class="nav-link">FAQ</a>
                    <a href="../controller/ForumController.php" class="nav-link active">Forum</a>
                    <a href="../contactUs.html" class="nav-link">Contact</a>
                    <?php if ($is_logged_in): ?>
                        <a href="../controller/DashboardController.php" class="nav-link">Dashboard</a>
                        <a href="../logout.php" class="nav-link">Logout</a>
                    <?php else: ?>
                        <a href="../login.html" class="login-btn">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <div class="content">
            <!-- Hero -->
            <div class="hero">
                <h1 class="hero-title">Community Forum</h1>
                <p class="hero-subtitle">Connect with fellow pet lovers, share stories, ask questions, and get advice from our amazing community.</p>
                <?php if ($is_logged_in): ?>
                    <button class="create-post-btn" onclick="openPostModal()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Create New Post
                    </button>
                <?php else: ?>
                    <button class="create-post-btn" onclick="alert('Please log in to create posts')" disabled>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Login to Create Post
                    </button>
                <?php endif; ?>
            </div>

            <!-- Alerts -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <strong>⚠️ Errors:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    ✓ <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <!-- Forum Container -->
            <div class="forum-container">
                <!-- Categories -->
                <div class="categories-section">
                    <h2 class="section-title">Browse Categories</h2>
                    <div class="categories-grid">
                        <?php if (!empty($topics)): ?>
                            <?php foreach ($topics as $topic): ?>
                                <div class="category-card">
                                    <div class="category-icon"><?php echo getCategoryIcon($topic['title']); ?></div>
                                    <div class="category-name"><?php echo htmlspecialchars($topic['title']); ?></div>
                                    <div class="category-description"><?php echo htmlspecialchars($topic['description']); ?></div>
                                    <div class="category-stats">
                                        <?php echo number_format($topic['post_count']); ?> posts • 
                                        <?php echo number_format($topic['member_count']); ?> members
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color: #666;">No topics available yet.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="posts-section">
                    <h2 class="section-title">Recent Discussions</h2>
                    <div class="posts-list">
                        <?php if (!empty($recent_posts)): ?>
                            <?php foreach ($recent_posts as $post): ?>
                                <a href="../controller/PostForumController.php?id=<?php echo $post['id']; ?>" class="post-card">
                                    <div class="post-header">
                                        <div class="post-meta">
                                            <div class="post-avatar">
                                                <?php echo strtoupper(substr($post['author_name'], 0, 2)); ?>
                                            </div>
                                            <div class="post-author-info">
                                                <div class="post-author"><?php echo htmlspecialchars($post['author_name']); ?></div>
                                                <div class="post-time">
                                                    <?php 
                                                    $time_ago = time() - strtotime($post['timestamp']);
                                                    if ($time_ago < 3600) {
                                                        echo floor($time_ago / 60) . ' minutes ago';
                                                    } elseif ($time_ago < 86400) {
                                                        echo floor($time_ago / 3600) . ' hours ago';
                                                    } else {
                                                        echo floor($time_ago / 86400) . ' days ago';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-category-tag"><?php echo htmlspecialchars($post['topic_title']); ?></div>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-title"><?php echo htmlspecialchars($post['title']); ?></div>
                                        <div class="post-excerpt">
                                            <?php echo htmlspecialchars(substr($post['content'], 0, 200)) . (strlen($post['content']) > 200 ? '...' : ''); ?>
                                        </div>
                                        </div>
                                <div class="post-footer">
                                    <div class="post-stat">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                        </svg>
                                        <?php echo $post['comment_count']; ?> replies
                                    </div>
                                    <div class="post-stat">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                        </svg>
                                        <?php echo $post['likes']; ?> likes
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #666; text-align: center; padding: 2rem;">No posts yet. Be the first!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Post Modal -->
    <div id="postModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Create New Post</h2>
                <button class="modal-close" onclick="closePostModal()">&times;</button>
            </div>
            <form method="POST">
                <div class="form-group">
                    <label>Select Topic</label>
                    <select name="topic_id" class="form-select" required>
                        <option value="">Choose a topic...</option>
                        <?php foreach ($topics as $topic): ?>
                            <option value="<?php echo $topic['id']; ?>">
                                <?php echo htmlspecialchars($topic['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Post Title</label>
                    <input type="text" name="title" class="form-input" placeholder="Enter your post title..." required>
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea name="content" class="form-textarea" placeholder="Write your post content..." required></textarea>
                </div>
                <button type="submit" name="create_post" class="btn-submit">Create Post</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <a href="../terms.html" class="footer-link">Terms of Service</a>
        <span class="footer-dot">•</span>
        <a href="../terms.html" class="footer-link">Privacy Policy</a>
        <span class="footer-dot">•</span>
        <a href="../terms.html" class="footer-link">Community Guidelines</a>
    </div>
</div>

<script>
    function openPostModal() {
        document.getElementById('postModal').classList.add('active');
    }

    function closePostModal() {
        document.getElementById('postModal').classList.remove('active');
    }

    window.onclick = function(event) {
        const modal = document.getElementById('postModal');
        if (event.target == modal) {
            closePostModal();
        }
    }
</script>