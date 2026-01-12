<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetStride | Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; 
            overflow-x: hidden; 
            color: #334155; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .container { min-height: 100vh; position: relative; }
        
        /* Navigation */
        .nav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.95);
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
        }

        .nav-logo {
            height: 3rem;
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
            padding: 8px 16px;
            border-radius: 8px;
        }

        .nav-link:hover,
        .nav-link.active {
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
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Dashboard Content */
        .dashboard-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.5);
        }

        .welcome-text {
            font-size: 32px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255,255,255,0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            font-size: 36px;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 800;
            color: #334155;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: #64748B;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 20px;
            border-radius: 16px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .action-btn span {
            font-size: 24px;
        }

        /* Activity Feed */
        .activity-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255,255,255,0.4);
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .activity-item {
            padding: 15px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s;
        }

        .activity-item:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-desc {
            flex: 1;
        }

        .activity-time {
            font-size: 12px;
            color: #94A3B8;
        }

        .activity-type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            margin-right: 10px;
        }

        .type-create { background: #dcfce7; color: #166534; }
        .type-update { background: #fef3c7; color: #92400e; }
        .type-delete { background: #fee2e2; color: #991b1b; }
        .type-view { background: #dbeafe; color: #1e40af; }

        .logout-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-card, .action-btn, .activity-section {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Navigation -->
    <nav class="nav">
        <div class="nav-content">
            <img src="../petstride-logo.png" alt="PetStride" class="nav-logo">
            <div class="nav-links">
                <a href="AdminDashboardController.php" class="nav-link active">Dashboard</a>
                <a href="AdminUsersController.php" class="nav-link">Users</a>
                <a href="AdminPetsController.php" class="nav-link">Pets</a>
                <a href="AdminJobsController.php" class="nav-link">Jobs</a>
                <a href="AdminFAQController.php" class="nav-link">FAQ</a>
                <a href="AdminForumController.php" class="nav-link">Forum</a>
                <a href="AdminReportsController.php" class="nav-link">Reports</a>
                <span class="admin-badge">⚡ Admin</span>
            </div>
        </div>
    </nav>

    <div class="dashboard-content">
        <!-- Header -->
        <header class="header-glass">
            <div>
                <h1 class="welcome-text">Admin Control Panel</h1>
                <p style="color: #64748B; font-size: 16px; margin-top: 5px;">Manage all aspects of PetStride</p>
            </div>
            <div class="user-info">
                <div>
                    <div style="font-weight: 700; font-size: 16px; text-align: right;">
                        <?php echo htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']); ?>
                    </div>
                    <div style="font-size: 12px; color: #667eea; text-align: right;">System Administrator</div>
                </div>
                <div class="user-avatar">
                    <?php echo strtoupper(substr($currentUser['first_name'], 0, 1)); ?>
                </div>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </header>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-value"><?php echo array_sum($stats['users_by_role'] ?? [0]); ?></div>
                <div class="stat-label">Total Users</div>
                <div style="margin-top: 10px; font-size: 12px; color: #64748B;">
                    <?php 
                    if (!empty($stats['users_by_role'])) {
                        foreach ($stats['users_by_role'] as $role => $count) {
                            echo ucfirst($role) . ": " . $count . " ";
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🐾</div>
                <div class="stat-value"><?php echo $stats['total_pets'] ?? 0; ?></div>
                <div class="stat-label">Registered Pets</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">💼</div>
                <div class="stat-value"><?php echo array_sum($stats['jobs_by_status'] ?? [0]); ?></div>
                <div class="stat-label">Total Jobs</div>
                <div style="margin-top: 10px; font-size: 12px; color: #64748B;">
                    <?php 
                    if (!empty($stats['jobs_by_status'])) {
                        foreach ($stats['jobs_by_status'] as $status => $count) {
                            echo ucfirst($status) . ": " . $count . " ";
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-value">$<?php echo number_format($stats['total_revenue'] ?? 0, 2); ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-value"><?php echo $stats['today_activities'] ?? 0; ?></div>
                <div class="stat-label">Today's Activity</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⚠️</div>
                <div class="stat-value"><?php echo $stats['pending_reports'] ?? 0; ?></div>
                <div class="stat-label">Pending Reports</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="AdminUsersController.php" class="action-btn">
                <span>👥</span> Manage Users
            </a>
            <a href="AdminPetsController.php" class="action-btn">
                <span>🐾</span> Manage Pets
            </a>
            <a href="AdminJobsController.php" class="action-btn">
                <span>💼</span> Manage Jobs
            </a>
            <a href="AdminFAQController.php" class="action-btn">
                <span>❓</span> Manage FAQ
            </a>
            <a href="AdminForumController.php" class="action-btn">
                <span>💬</span> Manage Forum
            </a>
            <a href="AdminReportsController.php" class="action-btn">
                <span>⚠️</span> View Reports
            </a>
        </div>

        <!-- Recent Activity -->
        <div class="activity-section">
            <h2 class="section-title">
                <span>📋</span> Recent Activity
            </h2>
            <?php if (!empty($recentActivity)): ?>
                <?php foreach ($recentActivity as $activity): ?>
                    <div class="activity-item">
                        <div class="activity-desc">
                            <span class="activity-type type-<?php echo strtolower($activity['action_type']); ?>">
                                <?php echo strtoupper($activity['action_type']); ?>
                            </span>
                            <strong><?php echo htmlspecialchars($activity['first_name'] . ' ' . $activity['last_name']); ?></strong>
                            <?php echo htmlspecialchars($activity['description']); ?>
                            <?php if ($activity['target_table']): ?>
                                <span style="color: #94A3B8;">
                                    (<?php echo htmlspecialchars($activity['target_table']); ?> #<?php echo $activity['target_id']; ?>)
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="activity-time">
                            <?php echo date('M d, H:i', strtotime($activity['timestamp'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: #94A3B8; padding: 20px;">No recent activity</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>