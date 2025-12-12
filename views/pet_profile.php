<?php
// Ensure $pet object is available (passed from controller)
if (!isset($pet)) {
    echo "No pet data available.";
    exit;
}

// Helper to format owner name
$ownerName = trim(($pet->owner_first_name ?? '') . ' ' . ($pet->owner_last_name ?? ''));
if (empty($ownerName)) $ownerName = "User";

// Helper for initials
$initial = strtoupper(substr($ownerName, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Profile - <?php echo htmlspecialchars($pet->name); ?></title>
    <style>
        /* ===========================
           Base Styles & Variables
           =========================== */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: 1px solid rgba(255, 255, 255, 0.2);
            --text-main: #333;
            --text-muted: #666;
            --sidebar-width: 280px;
            --font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* ===========================
           Animated Background
           =========================== */
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgb(217, 119, 87, 0.8) 50%, rgb(242, 242, 242, 0.8) 100%);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
            z-index: -1;
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* ===========================
           Sidebar Styles
           =========================== */
        .sidebar {
            width: var(--sidebar-width);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border-right: var(--glass-border);
            display: flex;
            flex-direction: column;
            padding: 30px;
            flex-shrink: 0;
            z-index: 10;
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

        /* ===========================
           Main Content Area
           =========================== */
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

        /* Decorative background circle for hero */
        .hero-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(217, 119, 87, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 50%;
            z-index: 0;
        }

        .pet-hero-image-container {
            position: relative;
            flex-shrink: 0;
            z-index: 1;
        }

        .pet-hero-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            background-color: #f7fafc;
        }

        /* Status Indicator Pill */
        .slider-indicator {
            margin-top: 15px;
            background: white;
            padding: 8px 20px;
            border-radius: 20px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            color: #764ba2;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            width: max-content;
            margin-left: auto;
            margin-right: auto;
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

        /* Profile Details Section */
        .profile-section {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: var(--glass-border);
        }

        .profile-section h2 {
            font-size: 28px;
            margin-bottom: 35px;
            color: #2d3748;
            font-weight: 700;
            border-bottom: 2px solid rgba(118, 75, 162, 0.1);
            padding-bottom: 15px;
            display: inline-block;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 50px;
            row-gap: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group label {
            font-weight: 600;
            font-size: 14px;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            color: #2d3748;
            outline: none;
            transition: all 0.3s;
            font-weight: 500;
        }

        .form-input:read-only {
            background-color: #f8fafc;
            color: #4a5568;
            cursor: default;
        }

        .form-input:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.1);
            background-color: white;
        }

        /* Responsive */
        @media (max-width: 992px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: auto;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                padding: 15px 30px;
                position: relative;
            }
            .menu-list {
                display: none; /* Mobile menu hidden for simplicity or make hamburger work */
            }
            .user-profile-summary {
                margin-bottom: 0;
                padding-bottom: 0;
                border: none;
            }
            .main-content {
                padding: 30px;
            }
            .hero-card {
                flex-direction: column;
                text-align: center;
                padding: 30px;
            }
            .details-grid {
                grid-template-columns: 1fr;
            }
            .pet-hero-image-container {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="background"></div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="user-profile-summary">
            <div class="avatar-circle">
                <?php echo $initial; ?>
            </div>
            <div class="user-info">
                <h3><?php echo htmlspecialchars($ownerName); ?></h3>
                <p><?php echo htmlspecialchars($pet->owner_role ?? 'Pet Owner'); ?></p>
            </div>
        </div>

        <ul class="menu-list">
            <li><a href="../controller/DashboardController.php" class="menu-item">Dashboard</a></li>
            <li><a href="#" class="menu-item">My Pets</a></li>
            <li><a href="#" class="menu-item">Settings</a></li>
            <li><a href="#" class="menu-item active">Profile</a></li>
            <li><a href="../logout.php" class="menu-item">Logout</a></li>
        </ul>
        
        <!-- Mobile hamburger placeholder if needed -->
        <div style="display:none;" class="mobile-menu-toggle">☰</div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Hero Card -->
        <div class="hero-card">
            <div class="pet-hero-image-container">
                <?php if (!empty($pet->photo_url)): ?>
                    <img src="<?php echo htmlspecialchars($pet->photo_url); ?>" alt="<?php echo htmlspecialchars($pet->name); ?>" class="pet-hero-image">
                <?php else: ?>
                    <div class="pet-hero-image" style="display:flex;align-items:center;justify-content:center;font-size:3rem;color:#764ba2;background:#f0f4f8;">
                        <?php echo strtoupper(substr($pet->name, 0, 1)); ?>
                    </div>
                <?php endif; ?>
                <div class="slider-indicator">
                    <?php echo htmlspecialchars($pet->is_active === 'yes' ? 'Active' : 'Inactive'); ?>
                </div>
            </div>
            
            <div class="hero-text">
                <h1>Hello, I'm <?php echo htmlspecialchars($pet->name); ?>! 🐾</h1>
                <p>
                    I'm a <?php echo htmlspecialchars($pet->age); ?>-year-old <strong><?php echo htmlspecialchars($pet->breed); ?></strong>. 
                    I weigh <strong><?php echo htmlspecialchars($pet->weight); ?>kg</strong> and bring joy to everyone I meet.
                    <br><br>
                    My owner loves me very much and keeps my vaccination status: 
                    <span style="color: <?php echo strpos(strtolower($pet->vaccintation_status), 'up to date') !== false ? '#48bb78' : '#e53e3e'; ?>; font-weight: bold;">
                        <?php echo htmlspecialchars($pet->vaccintation_status); ?>
                    </span>.
                </p>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="profile-section">
            <h2>Pet Profile Details</h2>

            <div class="details-grid">
                <!-- Name -->
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($pet->name); ?>" readonly>
                </div>

                <!-- Breed (Mapped to Username field in design) -->
                <div class="form-group">
                    <label>Breed</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($pet->breed); ?>" readonly>
                </div>

                <!-- Age -->
                <div class="form-group">
                    <label>Age</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($pet->age); ?> years" readonly>
                </div>

                <!-- Gender -->
                <div class="form-group">
                    <label>Gender</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($pet->gender); ?>" readonly>
                </div>

                <!-- Weight -->
                <div class="form-group">
                    <label>Weight</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($pet->weight); ?> kg" readonly>
                </div>

                <!-- Height -->
                <div class="form-group">
                    <label>Height</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($pet->height); ?> cm" readonly>
                </div>

                <!-- Color -->
                <div class="form-group">
                    <label>Color</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($pet->color); ?>" readonly>
                </div>

                <!-- Vaccination -->
                <div class="form-group">
                    <label>Vaccination Status</label>
                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($pet->vaccintation_status); ?>" readonly>
                </div>
            </div>
        </div>

    </main>

</body>
</html>