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

        .nav-logo {
            height: 3rem;
        }

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
            transition: all 0.3s;
            padding: 8px 16px;
            border-radius: 8px;
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

        /* Dashboard Content */
        .dashboard-content {
            position: relative;
            z-index: 2;
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.5);
            animation: fade-in 0.5s ease-out;
        }

        .welcome-text {
            font-size: 28px;
            background: linear-gradient(135deg, #4365ff, #002fff);
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
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255,255,255,0.4);
            transition: all 0.3s ease;
            animation: scale-in 0.5s ease-out;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.85);
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

        .stat-details {
            margin-top: 10px;
            font-size: 12px;
            color: #64748B;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-btn {
            background: linear-gradient(135deg, #4365ff, #002fff);
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
            transition: all 0.3s;
            box-shadow: 0 10px 25px rgba(67, 101, 255, 0.3);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(67, 101, 255, 0.4);
            opacity: 0.9;
        }

        .action-btn span {
            font-size: 24px;
        }

        /* Activity Feed */
        .activity-section {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255,255,255,0.4);
            animation: scale-in 0.5s ease-out;
        }

        .section-title {
            font-size: 20px;
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
            background: rgba(67, 101, 255, 0.05);
            border-radius: 8px;
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
            white-space: nowrap;
            margin-left: 15px;
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
        .type-post { background: #dbeafe; color: #1e40af; }
        .type-comment { background: #fef3c7; color: #92400e; }
        .type-update { background: #fef3c7; color: #92400e; }
        .type-delete { background: #fee2e2; color: #991b1b; }
        .type-view { background: #dbeafe; color: #1e40af; }

        .logout-btn {
            background: #ff4757;
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
            opacity: 0.9;
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
            background: linear-gradient(135deg, #4365ff, #002fff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
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
        @media (max-width: 1024px) {
            .nav-content {
                padding: 1rem 1.5rem;
            }

            .nav-links {
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
            }

            .quick-actions {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }
        }

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

            .nav-link {
                padding: 6px 12px;
                font-size: 14px;
            }

            .admin-badge {
                padding: 4px 12px;
                font-size: 10px;
            }

            .dashboard-content {
                padding: 20px 15px;
            }

            .header-glass {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
                text-align: center;
            }

            .welcome-text {
                font-size: 24px;
            }

            .user-info {
                flex-direction: column;
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .stat-value {
                font-size: 28px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .activity-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .activity-time {
                margin-left: 0;
            }

            .paw {
                font-size: 40px;
            }

            .heart-1, .heart-2 {
                font-size: 32px;
            }
        }

        @media (max-width: 480px) {
            .nav-logo {
                height: 2.5rem;
            }

            .nav-links {
                font-size: 12px;
                gap: 0.25rem;
                flex-wrap: wrap;
            }

            .nav-link {
                padding: 4px 8px;
            }

            .dashboard-content {
                padding: 15px 10px;
            }

            .header-glass {
                padding: 15px;
            }

            .welcome-text {
                font-size: 20px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 24px;
            }

            .stat-icon {
                font-size: 28px;
            }

            .action-btn {
                padding: 15px;
                font-size: 14px;
            }

            .action-btn span {
                font-size: 20px;
            }

            .activity-section {
                padding: 20px;
            }

            .section-title {
                font-size: 18px;
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
                    <div style="font-size: 12px; color: #4A9FD8; text-align: right;">System Administrator</div>
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
                <div class="stat-details">
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
                <div class="stat-details">
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
                            <?php echo htmlspecialchars($activity['description'] ?: 'Job'); ?>
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