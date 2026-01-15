<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetStride | User Management</title>
    <style>
        /* --- GLOBAL & RESET --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #334155; 
            min-height: 100vh;
        }
        
        /* --- NAVIGATION --- */
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

        /* --- LAYOUT --- */
        .content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* --- CARDS & CONTAINERS --- */
        .card, .page-header, .filters, .table-container, .content-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .page-header { margin-bottom: 30px; }
        
        .page-title {
            font-size: 32px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            margin-bottom: 10px;
        }
        
        .page-subtitle { color: #64748B; font-size: 16px; }

        /* --- FILTERS & FORMS --- */
        .filters {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
            padding: 20px;
        }
        .filter-input, .filter-select, .form-input, .form-textarea {
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: white;
            width: 100%;
        }
        .filter-input, .filter-select { flex: 1; min-width: 200px; width: auto; }
        .form-textarea { min-height: 120px; resize: vertical; font-family: inherit; }
        .filter-input:focus, .filter-select:focus, .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        /* --- BUTTONS --- */
        .btn, .filter-btn, .btn-primary, .btn-secondary {
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
        }
        .btn-primary, .filter-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .btn-primary:hover, .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary { background: #e2e8f0; color: #334155; }
        .btn-secondary:hover { background: #cbd5e1; }
        
        /* Small Action Buttons */
        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 8px; }
        .btn-edit { background: #3b82f6; color: white; }
        .btn-edit:hover { background: #2563eb; }
        .btn-delete { background: #ef4444; color: white; }
        .btn-delete:hover { background: #dc2626; }
        .btn-view { background: #8b5cf6; color: white; }
        .btn-lock { background: #f59e0b; color: white; }
        .btn-unlock { background: #10b981; color: white; }

        /* --- TABLES --- */
        .table-container { padding: 0; overflow: hidden; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            text-align: left;
            padding: 20px;
            background: #f8fafc;
            color: #64748B;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            border-bottom: 2px solid #e2e8f0;
        }
        .data-table td { padding: 20px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .data-table tr:hover { background: rgba(102, 126, 234, 0.05); }

        /* --- BADGES --- */
        .badge, .role-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .role-client, .badge-posts { background: #dbeafe; color: #1e40af; }
        .role-caregiver, .badge-unlocked { background: #dcfce7; color: #166534; }
        .role-admin, .badge-members { background: #fef3c7; color: #92400e; }
        .badge-locked { background: #fee2e2; color: #991b1b; }
        .badge-comments { background: #e0e7ff; color: #4338ca; }
        .badge-author { background: #f3e8ff; color: #6b21a8; }

        /* --- MODALS --- */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }
        .modal.active { display: flex; }
        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }
        .modal-title { font-size: 24px; font-weight: 700; margin-bottom: 25px; color: #1e293b; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: #334155; font-size: 14px; }
        .form-actions { display: flex; gap: 15px; justify-content: flex-end; margin-top: 30px; }

        /* --- ALERTS --- */
        .message { padding: 15px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .message-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .message-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* --- PAGINATION --- */
        .pagination { display: flex; gap: 8px; justify-content: center; margin: 30px 0; }
        .page-link {
            padding: 8px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.5);
            color: #64748B;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .page-link:hover, .page-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
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
                <a href="AdminUsersController.php" class="nav-link active">Users</a>
                <a href="AdminPetsController.php" class="nav-link">Pets</a>
                <a href="AdminJobsController.php" class="nav-link">Jobs</a>
                <a href="AdminFAQController.php" class="nav-link">FAQ</a>
                <a href="AdminForumController.php" class="nav-link">Forum</a>
                <a href="AdminReportsController.php" class="nav-link">Reports</a>
                <span class="admin-badge">⚡ Admin</span>
            </div>
        </div>
    </nav>

    <div class="content">
        <div class="page-header">
            <h1 class="page-title">👥 User Management</h1>
            <p class="page-subtitle">Manage all registered users on PetStride</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message message-<?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="GET" action="" class="filters">
            <input type="text" name="search" placeholder="Search by name or email..." class="filter-input" value="<?php echo htmlspecialchars($search); ?>">
            <select name="role" class="filter-select">
                <option value="">All Roles</option>
                <option value="client" <?php echo $roleFilter === 'client' ? 'selected' : ''; ?>>Client</option>
                <option value="caregiver" <?php echo $roleFilter === 'caregiver' ? 'selected' : ''; ?>>Caregiver</option>
                <option value="admin" <?php echo $roleFilter === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
            <button type="submit" class="filter-btn">🔍 Search</button>
            <a href="AdminUsersController.php" class="btn btn-secondary">🔄 Reset</a>
        </form>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>City</th>
                        <th>Pets</th>
                        <th>Jobs</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><strong>#<?php echo $user['id']; ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                                <td><span class="role-badge role-<?php echo $user['role']; ?>"><?php echo strtoupper($user['role']); ?></span></td>
                                <td><?php echo htmlspecialchars($user['city'] ?? 'N/A'); ?></td>
                                <td><?php echo $user['total_pets']; ?></td>
                                <td><?php echo $user['job_count']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <div class="action-btns" style="display:flex; gap:5px;">
                                        <a href="?edit=<?php echo $user['id']; ?>" class="btn btn-sm btn-edit">✏️</a>
                                        <button onclick="confirmDelete(<?php echo $user['id']; ?>)" class="btn btn-sm btn-delete">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="10" style="text-align: center; padding: 40px; color: #94A3B8;">No users found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&role=<?php echo urlencode($roleFilter); ?>" class="page-link">← Prev</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&role=<?php echo urlencode($roleFilter); ?>" class="page-link <?php echo $page === $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&role=<?php echo urlencode($roleFilter); ?>" class="page-link">Next →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($editUser): ?>
<div class="modal active" id="editModal">
    <div class="modal-content">
        <h2 class="modal-title">✏️ Edit User</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="user_id" value="<?php echo $editUser['id']; ?>">
            <div class="form-group">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-input" value="<?php echo htmlspecialchars($editUser['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-input" value="<?php echo htmlspecialchars($editUser['last_name']); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="<?php echo htmlspecialchars($editUser['email']); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-input" required>
                    <option value="client" <?php echo $editUser['role'] === 'client' ? 'selected' : ''; ?>>Client</option>
                    <option value="caregiver" <?php echo $editUser['role'] === 'caregiver' ? 'selected' : ''; ?>>Caregiver</option>
                    <option value="admin" <?php echo $editUser['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <div class="form-actions">
                <a href="AdminUsersController.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<form id="deleteForm" method="POST" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="user_id" id="deleteUserId">
</form>

<script>
function confirmDelete(userId) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        document.getElementById('deleteUserId').value = userId;
        document.getElementById('deleteForm').submit();
    }
}
</script>
</body>
</html>