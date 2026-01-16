<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetStride | Pet Management</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; 
            overflow-x: hidden; 
            color: #334155; 
        }
        
        /* Background & Animations */
        .container { min-height: 100vh; position: relative; overflow-y: auto; }
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
        
        .paw-container { position: fixed; inset: 0; overflow: hidden; pointer-events: none; z-index: 0; }
        .paw { position: absolute; font-size: 60px; opacity: 0.1; animation: float-paw 20s infinite ease-in-out; }
        @keyframes float-paw { 
            0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.1; } 
            50% { transform: translate(30px, -30px) rotate(180deg); opacity: 0.05; } 
        }
        
        .heart { position: absolute; animation: floating 3s ease-in-out infinite; z-index: 0;}
        @keyframes floating { 
            0%, 100% { transform: translateY(0px); } 
            50% { transform: translateY(-20px); } 
        }
        .heart-1 { top: 40px; left: 40px; font-size: 48px; opacity: 0.2; }
        .heart-2 { top: 80px; right: 80px; font-size: 64px; opacity: 0.2; animation-delay: 1s; }
        
        /* Navigation */
        .nav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .nav-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .nav-logo { height: 3rem; }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-link {
            color: rgba(0, 0, 0, 0.7);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #4365ff;
            background: rgba(67, 101, 255, 0.1);
        }

        .admin-badge {
            background: linear-gradient(135deg, #4365ff, #002fff);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Main Content */
        .content {
            position: relative;
            z-index: 2;
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255,255,255,0.5);
            animation: fade-in 0.5s ease-out;
        }

        .page-title {
            font-size: 32px;
            background: linear-gradient(135deg, #4365ff, #002fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            margin-bottom: 10px;
        }

        /* Filters */
        .filters {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255,255,255,0.5);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
            animation: scale-in 0.5s ease-out;
        }

        .filter-input {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            flex: 1;
            min-width: 200px;
            background: rgba(255, 255, 255, 0.9);
        }

        .filter-input:focus {
            outline: none;
            border-color: #4365ff;
            background: white;
        }

        .filter-btn {
            background: linear-gradient(135deg, #4365ff, #002fff);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(67, 101, 255, 0.3);
            text-decoration: none;
            display: inline-block;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(67, 101, 255, 0.4);
        }

        /* Table */
        .table-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255,255,255,0.5);
            overflow-x: auto;
            animation: scale-in 0.5s ease-out;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 15px;
            color: #64748B;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 700;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .data-table tr:hover {
            background: rgba(67, 101, 255, 0.05);
        }

        .pet-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-active { background: #dcfce7; color: #166534; }
        .status-inactive { background: #fee2e2; color: #991b1b; }

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

        .btn-edit:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
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
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modal-appear 0.3s ease-out;
        }

        @keyframes modal-appear {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #4365ff, #002fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #4365ff;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4365ff, #002fff);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(67, 101, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(67, 101, 255, 0.4);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        /* Message */
        .message {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
            animation: fade-in 0.5s ease-out;
        }

        .message-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .message-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .page-link {
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            color: #4365ff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: 1px solid rgba(67, 101, 255, 0.2);
        }

        .page-link:hover,
        .page-link.active {
            background: linear-gradient(135deg, #4365ff, #002fff);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 101, 255, 0.3);
        }

        @keyframes fade-in { 
            0% { opacity: 0; transform: translateY(10px); } 
            100% { opacity: 1; transform: translateY(0); } 
        }
        
        @keyframes scale-in { 
            0% { opacity: 0; transform: scale(0.95); } 
            100% { opacity: 1; transform: scale(1); } 
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .nav-content {
                flex-direction: column;
                padding: 1rem;
            }

            .nav-links {
                width: 100%;
                justify-content: center;
                gap: 0.5rem;
            }

            .content {
                padding: 20px 15px;
            }

            .filters {
                flex-direction: column;
            }

            .filter-input {
                min-width: 100%;
            }

            .table-container {
                padding: 15px;
            }

            .data-table {
                font-size: 14px;
            }

            .data-table th,
            .data-table td {
                padding: 10px 5px;
            }

            .paw {
                font-size: 40px;
            }
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
            <img src="../petstride-logo.png" alt="PetStride" class="nav-logo">
            <div class="nav-links">
                <a href="AdminDashboardController.php" class="nav-link">Dashboard</a>
                <a href="AdminUsersController.php" class="nav-link">Users</a>
                <a href="AdminPetsController.php" class="nav-link active">Pets</a>
                <a href="AdminJobsController.php" class="nav-link">Jobs</a>
                <a href="AdminForumController.php" class="nav-link">Forum</a>
                <span class="admin-badge">⚡ Admin</span>
            </div>
        </div>
    </nav>

    <div class="content">
        <!-- Header -->
        <div class="page-header">
            <h1 class="page-title">🐾 Pet Management</h1>
            <p style="color: #64748B;">Manage all registered pets on PetStride</p>
        </div>

        <!-- Message -->
        <?php if (!empty($message)): ?>
            <div class="message message-<?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Filters -->
        <form method="GET" action="" class="filters">
            <input type="text" 
                   name="search" 
                   placeholder="Search by pet name or owner..." 
                   class="filter-input"
                   value="<?php echo htmlspecialchars($search); ?>">
            
            <button type="submit" class="filter-btn">🔍 Search</button>
            <a href="AdminPetsController.php" class="filter-btn">🔄 Reset</a>
        </form>

        <!-- Table -->
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Owner</th>
                        <th>Vaccination</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pets)): ?>
                        <?php foreach ($pets as $pet): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($pet['photo_url'] ?? 'https://via.placeholder.com/50'); ?>" 
                                         alt="<?php echo htmlspecialchars($pet['name']); ?>" 
                                         class="pet-avatar">
                                </td>
                                <td><strong>#<?php echo $pet['id']; ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($pet['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($pet['age'] ?? 'N/A'); ?> yrs</td>
                                <td><?php echo htmlspecialchars($pet['gender'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($pet['owner_first_name'] . ' ' . $pet['owner_last_name']); ?><br>
                                    <small style="color: #94A3B8;"><?php echo htmlspecialchars($pet['owner_email']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($pet['vaccintation_status'] ?? 'Unknown'); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $pet['is_active'] === 'yes' ? 'active' : 'inactive'; ?>">
                                        <?php echo $pet['is_active'] === 'yes' ? 'ACTIVE' : 'INACTIVE'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="?edit=<?php echo $pet['id']; ?>" class="btn btn-edit">✏️ Edit</a>
                                        <button onclick="confirmDelete(<?php echo $pet['id']; ?>)" class="btn btn-delete">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 40px; color: #94A3B8;">
                                No pets found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">← Prev</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
                           class="page-link <?php echo $page === $i ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">Next →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<?php if ($editPet): ?>
<div class="modal active" id="editModal">
    <div class="modal-content">
        <h2 class="modal-title">✏️ Edit Pet</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="pet_id" value="<?php echo $editPet['id']; ?>">
            
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-input" value="<?php echo htmlspecialchars($editPet['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Breed</label>
                <input type="text" name="breed" class="form-input" value="<?php echo htmlspecialchars($editPet['breed'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-input" value="<?php echo htmlspecialchars($editPet['age'] ?? ''); ?>" min="0">
            </div>
            
            <div class="form-group">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-input">
                    <option value="Male" <?php echo $editPet['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $editPet['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Weight (kg)</label>
                <input type="number" step="0.1" name="weight" class="form-input" value="<?php echo htmlspecialchars($editPet['weight'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Height (cm)</label>
                <input type="number" step="0.1" name="height" class="form-input" value="<?php echo htmlspecialchars($editPet['height'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-input" value="<?php echo htmlspecialchars($editPet['color'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Vaccination Status</label>
                <select name="vaccintation_status" class="form-input">
                    <option value="Up to date" <?php echo $editPet['vaccintation_status'] === 'Up to date' ? 'selected' : ''; ?>>Up to date</option>
                    <option value="Needs update" <?php echo $editPet['vaccintation_status'] === 'Needs update' ? 'selected' : ''; ?>>Needs update</option>
                    <option value="Unknown" <?php echo $editPet['vaccintation_status'] === 'Unknown' ? 'selected' : ''; ?>>Unknown</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-input">
                    <option value="yes" <?php echo $editPet['is_active'] === 'yes' ? 'selected' : ''; ?>>Active</option>
                    <option value="no" <?php echo $editPet['is_active'] === 'no' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            
            <div class="form-actions">
                <a href="AdminPetsController.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="pet_id" id="deletePetId">
</form>

<script>
function confirmDelete(petId) {
    if (confirm('Are you sure you want to delete this pet? This action cannot be undone.')) {
        document.getElementById('deletePetId').value = petId;
        document.getElementById('deleteForm').submit();
    }
}
</script>

</body>
</html>