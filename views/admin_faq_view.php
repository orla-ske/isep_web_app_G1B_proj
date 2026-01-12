<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetStride | FAQ Management</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 32px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
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
        }

        .filter-select {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            flex: 1;
            max-width: 300px;
        }

        .faq-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .faq-item {
            border-bottom: 1px solid #e2e8f0;
            padding: 20px 0;
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 20px;
        }

        .faq-question {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            flex: 1;
        }

        .faq-answer {
            margin-top: 10px;
            color: #64748B;
            line-height: 1.6;
        }

        .faq-meta {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-category {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-order {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-btns {
            display: flex;
            gap: 8px;
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
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

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

        .form-input,
        .form-textarea {
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

        .form-checkbox {
            width: auto;
            margin-right: 8px;
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

        .message-success {
            background: #dcfce7;
            color: #166534;
        }

        .message-error {
            background: #fee2e2;
            color: #991b1b;
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
                <a href="AdminFAQController.php" class="nav-link active">FAQ</a>
                <a href="AdminForumController.php" class="nav-link">Forum</a>
                <a href="AdminReportsController.php" class="nav-link">Reports</a>
                <span class="admin-badge">⚡ Admin</span>
            </div>
        </div>
    </nav>

    <div class="content">
        <div class="page-header">
            <div>
                <h1 class="page-title">❓ FAQ Management</h1>
                <p style="color: #64748B;">Manage frequently asked questions</p>
            </div>
            <a href="?create=1" class="btn-create">+ Add New FAQ</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message message-<?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="GET" action="" class="filters">
            <select name="category" class="filter-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $categoryFilter === $cat ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <a href="AdminFAQController.php" class="btn-create" style="padding: 10px 20px;">🔄 Reset</a>
        </form>

        <div class="faq-container">
            <?php if (!empty($faqs)): ?>
                <?php foreach ($faqs as $faq): ?>
                    <div class="faq-item">
                        <div class="faq-header">
                            <div style="flex: 1;">
                                <div class="faq-question"><?php echo htmlspecialchars($faq['question']); ?></div>
                                <div class="faq-answer"><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></div>
                                <div class="faq-meta">
                                    <?php if ($faq['category']): ?>
                                        <span class="badge badge-category">📁 <?php echo htmlspecialchars($faq['category']); ?></span>
                                    <?php endif; ?>
                                    <span class="badge badge-order">📊 Order: <?php echo $faq['display_order']; ?></span>
                                    <span class="badge <?php echo $faq['is_active'] ? 'badge-active' : 'badge-inactive'; ?>">
                                        <?php echo $faq['is_active'] ? '✓ Active' : '✗ Inactive'; ?>
                                    </span>
                                    <?php if ($faq['first_name']): ?>
                                        <span class="badge" style="background: #e0e7ff; color: #4338ca;">
                                            👤 By: <?php echo htmlspecialchars($faq['first_name'] . ' ' . $faq['last_name']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="action-btns">
                                <a href="?edit=<?php echo $faq['id']; ?>" class="btn btn-edit">✏️</a>
                                <button onclick="confirmDelete(<?php echo $faq['id']; ?>)" class="btn btn-delete">🗑️</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; padding: 40px; color: #94A3B8;">No FAQs found</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Create/Edit Modal -->
<?php if ($showCreate || $editFAQ): ?>
<div class="modal active">
    <div class="modal-content">
        <h2 class="modal-title"><?php echo $editFAQ ? '✏️ Edit FAQ' : '➕ Create New FAQ'; ?></h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="<?php echo $editFAQ ? 'update' : 'create'; ?>">
            <?php if ($editFAQ): ?>
                <input type="hidden" name="faq_id" value="<?php echo $editFAQ['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label class="form-label">Question *</label>
                <input type="text" name="question" class="form-input" 
                       value="<?php echo $editFAQ ? htmlspecialchars($editFAQ['question']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Answer *</label>
                <textarea name="answer" class="form-textarea" required><?php echo $editFAQ ? htmlspecialchars($editFAQ['answer']) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-input" 
                       value="<?php echo $editFAQ ? htmlspecialchars($editFAQ['category']) : ''; ?>"
                       placeholder="e.g., General, Caregivers, Payments">
            </div>
            
            <div class="form-group">
                <label class="form-label">Display Order</label>
                <input type="number" name="display_order" class="form-input" 
                       value="<?php echo $editFAQ ? $editFAQ['display_order'] : '0'; ?>" 
                       min="0">
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="is_active" class="form-checkbox" 
                           <?php echo (!$editFAQ || $editFAQ['is_active']) ? 'checked' : ''; ?>>
                    <span class="form-label" style="margin: 0;">Active</span>
                </label>
            </div>
            
            <div class="form-actions">
                <a href="AdminFAQController.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                    <?php echo $editFAQ ? 'Save Changes' : 'Create FAQ'; ?>
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<form id="deleteForm" method="POST" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="faq_id" id="deleteFaqId">
</form>

<script>
function confirmDelete(faqId) {
    if (confirm('Are you sure you want to delete this FAQ?')) {
        document.getElementById('deleteFaqId').value = faqId;
        document.getElementById('deleteForm').submit();
    }
}
</script>

</body>
</html>