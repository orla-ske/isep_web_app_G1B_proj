<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - PetStride</title>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: 1px solid rgba(255, 255, 255, 0.2);
            --text-main: #333;
            --text-muted: #666;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
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

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border-right: var(--glass-border);
            display: flex;
            flex-direction: column;
            padding: 30px;
            flex-shrink: 0;
            height: 100vh;
            position: sticky;
            top: 0;
            box-shadow: 5px 0 25px rgba(0,0,0,0.05);
        }

        .user-profile-summary {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 50px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .avatar-circle {
            width: 56px;
            height: 56px;
            background: var(--primary-gradient);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(118, 75, 162, 0.3);
            overflow: hidden;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #2d3748;
        }

        .user-info p {
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .menu-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .menu-item {
            padding: 14px 20px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            color: #4a5568;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .menu-item:hover {
            background-color: rgba(118, 75, 162, 0.08);
            transform: translateX(5px);
            color: #764ba2;
        }

        .menu-item.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3);
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 40px 60px;
            overflow-y: auto;
            position: relative;
        }

        /* Hero Card */
        .hero-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            display: flex;
            align-items: center;
            gap: 50px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: var(--glass-border);
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(113, 154, 252, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 50%;
            z-index: 0;
        }

        .profile-image-container {
            position: relative;
            flex-shrink: 0;
            z-index: 1;
            text-align: center;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: bold;
            margin: 0 auto;
        }

        .upload-btn {
            margin-top: 15px;
            background: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            color: #764ba2;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 2px solid #764ba2;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-btn:hover {
            background: #764ba2;
            color: white;
        }

        .hero-text {
            flex-grow: 1;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 32px;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-text p {
            font-size: 16px;
            line-height: 1.8;
            color: #4a5568;
        }

        /* Profile Sections */
        .profile-section {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: var(--glass-border);
            margin-bottom: 30px;
        }

        .profile-section h2 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #2d3748;
            font-weight: 700;
            border-bottom: 2px solid rgba(118, 75, 162, 0.1);
            padding-bottom: 15px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 30px;
            row-gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 600;
            font-size: 14px;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group label span {
            color: #e53e3e;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            color: #2d3748;
            outline: none;
            transition: all 0.3s;
            font-weight: 500;
        }

        .form-input:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.1);
            background-color: white;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-error {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
        }

        .alert-error ul {
            margin-left: 20px;
            margin-top: 5px;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(118, 75, 162, 0.4);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        @media (max-width: 992px) {
            body { flex-direction: column; }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .menu-list { display: none; }
            .main-content { padding: 30px 20px; }
            .hero-card {
                flex-direction: column;
                text-align: center;
            }
            .details-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="background"></div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="user-profile-summary">
            <div class="avatar-circle">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="../<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile">
                <?php else: ?>
                    <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                <?php endif; ?>
            </div>
            <div class="user-info">
                <h3><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
                <p><?php echo htmlspecialchars(ucfirst($user['role'] ?? 'User')); ?></p>
            </div>
        </div>

        <ul class="menu-list">
            <li><a href="../controller/DashboardController.php" class="menu-item">Dashboard</a></li>
            <li><a href="../controller/JobsController.php" class="menu-item">Jobs</a></li>
            <li><a href="#" class="menu-item active">Settings</a></li>
            <li><a href="../controller/LogoutController.php" class="menu-item">Logout</a></li>
        </ul>
    </aside>
    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Hero Card -->
        <div class="hero-card">
            <form method="POST" enctype="multipart/form-data" class="profile-image-container">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="../<?php echo htmlspecialchars($user['profile_picture']); ?>" 
                         alt="Profile" class="profile-image" style="background: none;">
                <?php else: ?>
                    <div class="profile-image">
                        <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                <input type="file" name="profile_picture" id="profile-picture-input" 
                       accept="image/*" style="display: none;" onchange="this.form.submit()">
                <label for="profile-picture-input" class="upload-btn">Change Photo</label>
            </form>
            
            <div class="hero-text">
                <h1>Hello, <?php echo htmlspecialchars($user['first_name']); ?>! 👋</h1>
                <p>
                    Manage your profile information and account settings. 
                    Keep your details up to date to ensure the best experience on PetStride.
                </p>
            </div>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <strong>⚠️ Please fix the following errors:</strong>
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

        <!-- Profile Information -->
        <div class="profile-section">
            <h2>Profile Information</h2>
            <form method="POST">
                <div class="details-grid">
                    <div class="form-group">
                        <label>First Name <span>*</span></label>
                        <input type="text" name="first_name" class="form-input" 
                               value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Last Name <span>*</span></label>
                        <input type="text" name="last_name" class="form-input" 
                               value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email <span>*</span></label>
                        <input type="email" name="email" class="form-input" 
                               value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" class="form-input" 
                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-input" 
                               value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" class="form-input" 
                               value="<?php echo htmlspecialchars($user['postal_code'] ?? ''); ?>">
                    </div>

                    <div class="form-group full-width">
                        <label>Address</label>
                        <input type="text" name="address" class="form-input" 
                               value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-secondary" 
                            onclick="window.location.href='../controller/DashboardController.php'">Cancel</button>
                    <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="profile-section">
            <h2>Change Password</h2>
            <form method="POST">
                <div class="details-grid">
                    <div class="form-group full-width">
                        <label>Current Password <span>*</span></label>
                        <input type="password" name="current_password" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label>New Password <span>*</span></label>
                        <input type="password" name="new_password" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label>Confirm New Password <span>*</span></label>
                        <input type="password" name="confirm_password" class="form-input" required>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>

    </main>
</body>
</html>