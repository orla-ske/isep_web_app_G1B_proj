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
            background: linear-gradient(135deg, rgba(242, 242, 242, 0.8) 0%, rgba(113, 154, 252, 0.8) 50%, rgba(242, 242, 242, 0.8) 100%);
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

        /* Edit Mode Styles */
        .action-btn {
            padding: 8px 16px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        #editBtn {
            background: white;
            color: #764ba2;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        #editBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }
        
        .save-btn {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(72, 187, 120, 0.3);
        }
        
        .cancel-btn {
            background: #f7fafc;
            color: #e53e3e;
            border: 1px solid #fed7d7;
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(0,0,0,0.5);
            display: none; /* Hidden by default */
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            font-weight: 600;
            backdrop-filter: blur(2px);
            transition: opacity 0.3s;
            z-index: 10;
        }
        
        .photo-overlay:hover {
            background: rgba(0,0,0,0.7);
        }

        .form-input-inline {
            background: rgba(255,255,255,0.9);
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 4px 8px;
            font-size: inherit;
            font-weight: inherit;
            font-family: inherit;
            color: #2d3748;
            width: 200px;
        }
        
        .form-input-inline-small {
            width: 80px;
            text-align: center;
            background: rgba(255,255,255,0.9);
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 4px;
            font-size: inherit;
        }

        .form-input-static {
            display: block;
            padding: 16px 20px;
            background-color: #dbeaf8;
            border-radius: 12px;
            border: 2px solid transparent;
            color: #4a5568;
            font-weight: 500;
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
        <!-- Messages -->
        <?php if (isset($success_message)): ?>
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" id="profileForm">
            <input type="hidden" name="update_pet" value="1">
            <input type="hidden" name="pet_id" value="<?php echo $pet->id; ?>">
            
            <!-- Hero Card -->
            <div class="hero-card">
                <div class="edit-controls" style="position: absolute; top: 20px; right: 20px; z-index: 10;">
                    <button type="button" id="editBtn" onclick="toggleEditMode()" class="action-btn">
                        ✏️ Edit Profile
                    </button>
                    <div id="saveCancelBtns" style="display: none; gap: 10px; align-items: center;">
                        <div id="edit-error-msg" style="color: #e53e3e; font-weight: bold; font-size: 13px; display: none; background: rgba(255,255,255,0.9); padding: 5px 10px; border-radius: 8px;"></div>
                        <button type="submit" class="action-btn save-btn">💾 Save</button>
                        <button type="button" onclick="cancelEdit()" class="action-btn cancel-btn">✕ Cancel</button>
                    </div>
                </div>

                <div class="pet-hero-image-container">
                    <div class="image-wrapper" style="position: relative; width: 200px; height: 200px; border-radius: 50%;">
                        <?php if (!empty($pet->photo_url)): ?>
                            <img src="<?php echo htmlspecialchars($pet->photo_url); ?>" id="petImagePreview" alt="<?php echo htmlspecialchars($pet->name); ?>" class="pet-hero-image">
                        <?php else: ?>
                            <div class="pet-hero-image" id="petPlaceholder" style="display:flex;align-items:center;justify-content:center;font-size:3rem;color:#764ba2;background:#f0f4f8;">
                                <?php echo strtoupper(substr($pet->name, 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Photo Upload Overlay (Visible in Edit Mode) -->
                        <div id="photoOverlay" class="photo-overlay" onclick="document.getElementById('photoInput').click()">
                            <span>📷 Change Photo</span>
                        </div>
                        <input type="file" name="photo" id="photoInput" style="display: none;" accept="image/*" onchange="previewImage(this)">
                    </div>

                    <div class="slider-indicator">
                        <span class="view-field"><?php echo htmlspecialchars($pet->is_active === 'yes' ? 'Active' : 'Inactive'); ?></span>
                        <select name="is_active" class="edit-field" style="display: none; border: none; background: transparent; font-weight: bold; color: #764ba2; text-align: center; font-size: 14px; width: 100%;">
                            <option value="yes" <?php echo $pet->is_active === 'yes' ? 'selected' : ''; ?>>Active</option>
                            <option value="no" <?php echo $pet->is_active !== 'yes' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="hero-text">
                    <h1>Hello, I'm <span class="view-field"><?php echo htmlspecialchars($pet->name); ?></span><input type="text" name="name" class="edit-field form-input-inline" value="<?php echo htmlspecialchars($pet->name); ?>" style="display: none;">! 🐾</h1>
                    <p>
                        I'm a <span class="view-field"><?php echo htmlspecialchars($pet->age); ?></span><input type="number" name="age" class="edit-field form-input-inline-small" value="<?php echo htmlspecialchars($pet->age); ?>" style="display: none;">-year-old 
                        <strong><span class="view-field"><?php echo htmlspecialchars($pet->breed); ?></span><input type="text" name="breed" class="edit-field form-input-inline" value="<?php echo htmlspecialchars($pet->breed); ?>" style="display: none;"></strong>. 
                        <br><br>
                        My owner loves me very much and keeps my vaccination status: 
                        <span class="view-field" style="color: <?php echo strpos(strtolower($pet->vaccintation_status ?? ''), 'up to date') !== false ? '#48bb78' : '#e53e3e'; ?>; font-weight: bold;">
                            <?php echo htmlspecialchars($pet->vaccintation_status); ?>
                        </span>
                        <input type="text" name="vaccination_status" class="edit-field form-input-inline" value="<?php echo htmlspecialchars($pet->vaccintation_status); ?>" style="display: none;">.
                    </p>
                </div>
            </div>

            <div class="profile-section">
                <h2>Pet Profile Details</h2>

                <div class="details-grid">

                    <div class="form-group">
                        <label>Gender</label>
                        <span class="view-field form-input-static"><?php echo htmlspecialchars($pet->gender); ?></span>
                        <select name="gender" class="edit-field form-input" style="display: none;">
                            <option value="Male" <?php echo $pet->gender === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $pet->gender === 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <span class="view-field form-input-static"><?php echo htmlspecialchars($pet->weight); ?> kg</span>
                        <input type="number" step="0.1" name="weight" class="edit-field form-input" value="<?php echo htmlspecialchars($pet->weight); ?>" style="display: none;">
                    </div>

                    <div class="form-group">
                        <label>Height (cm)</label>
                        <span class="view-field form-input-static"><?php echo htmlspecialchars($pet->height); ?> cm</span>
                        <input type="number" step="0.1" name="height" class="edit-field form-input" value="<?php echo htmlspecialchars($pet->height); ?>" style="display: none;">
                    </div>

                    <div class="form-group">
                        <label>Color</label>
                        <span class="view-field form-input-static"><?php echo htmlspecialchars($pet->color); ?></span>
                        <input type="text" name="color" class="edit-field form-input" value="<?php echo htmlspecialchars($pet->color); ?>" style="display: none;">
                    </div>

                    <div class="form-group">
                        <label>Vaccination Details</label>
                        <span class="view-field form-input-static"><?php echo htmlspecialchars($pet->vaccintation_status); ?></span>
                        
                        <select name="vaccination_status" id="vaccinationSelect" class="edit-field form-input" style="display: none;" onchange="updateHeroVaccination(this.value)">
                            <option value="">Select Status...</option>
                            <option value="Up to date" <?php echo strtolower($pet->vaccintation_status ?? '') === 'up to date' ? 'selected' : ''; ?>>Up to date</option>
                            <option value="Expired" <?php echo strtolower($pet->vaccintation_status ?? '') === 'expired' ? 'selected' : ''; ?>>Expired</option>
                        </select>
                        
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            const name = document.querySelector('input[name="name"]').value.trim();
            const breed = document.querySelector('input[name="breed"]').value.trim();
            const age = document.querySelector('input[name="age"]').value.trim();
            const vaccStatus = document.getElementById('vaccinationSelect').value;
            const errorMsg = document.getElementById('edit-error-msg');


            errorMsg.style.display = 'none';

            if (!name || !breed || !age || !vaccStatus) {
                e.preventDefault();
                errorMsg.innerText = '⚠️ Please fill in all required fields (Name, Breed, Age, Vaccination)';
                errorMsg.style.display = 'block';
                return false;
            }
        });

        function updateHeroVaccination(val) {
            const heroInput = document.querySelector('input[name="vaccination_status"]'); 
            if(heroInput) heroInput.value = val;
        }

        function toggleEditMode() {
            document.getElementById('editBtn').style.display = 'none';
            document.getElementById('saveCancelBtns').style.display = 'flex';
            
            document.querySelectorAll('.view-field').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.edit-field').forEach(el => el.style.display = 'inline-block');
            document.querySelectorAll('.form-group .edit-field').forEach(el => el.style.display = 'block'); 
            
            document.getElementById('photoOverlay').style.display = 'flex';
        }

        function cancelEdit() {
            location.reload();
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('petImagePreview');
                    const placeholder = document.getElementById('petPlaceholder');
                    
                    if (img) {
                        img.src = e.target.result;
                    } else if (placeholder) {
                        const newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.id = 'petImagePreview';
                        newImg.className = 'pet-hero-image';
                        newImg.alt = 'New Photo';
                        placeholder.parentNode.replaceChild(newImg, placeholder);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>
</html>