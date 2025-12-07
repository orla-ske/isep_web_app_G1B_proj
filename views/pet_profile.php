<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pet->name); ?> - Pet Profile</title>
    <style>
        /* Base Styles from Landing Page for consistency */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            min-height: 100vh;
        }

        /* Animated Background */
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

        /* Navigation Styles from Landing Page */
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

        .nav-btn {
            padding: 0.5rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Profile Specific Styles */
        .pet-profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }

        .pet-header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap; /* Responsive wrap */
            justify-content: center; /* Center on mobile */
        }

        @media (min-width: 600px) {
            .pet-header {
                justify-content: flex-start;
                flex-wrap: nowrap;
            }
        }

        .pet-photo {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: #ddd;
        }

        @media (min-width: 600px) {
            .pet-photo {
                margin-right: 40px;
                margin-bottom: 0;
            }
        }

        .pet-info {
            text-align: center;
        }

        @media (min-width: 600px) {
            .pet-info {
                text-align: left;
            }
        }

        .pet-info h1 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 2.5rem;
        }

        .pet-info p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 5px;
            line-height: 1.6;
        }

        .pet-details {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        @media (min-width: 600px) {
            .pet-details {
                grid-template-columns: 1fr 1fr;
            }
        }

        .detail-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            transition: transform 0.2s;
            border-left: 4px solid #D97757;
        }

        .detail-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .detail-label {
            font-weight: bold;
            color: #7f8c8d;
            text-transform: uppercase;
            font-size: 0.85rem;
            display: block;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 1.2rem;
            color: #2c3e50;
            font-weight: 500;
        }

        .status-active {
            color: #27ae60;
            font-weight: bold;
        }

        .status-inactive {
            color: #c0392b;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="background"></div>

    <!-- Navigation -->
    <nav class="nav">
        <div class="nav-content">
            <a href="../html/landingPage.html" class="logo-link">
                <img src="../img/petstride-logo.png" alt="PetStride" class="nav-logo">
            </a>
            <div class="nav-links">
                <a href="../html/landingPage.html" class="nav-link">Home</a>
                <a href="../html/about_us.html" class="nav-link">About Us</a>
                <a href="../html/FAQ.html" class="nav-link">FAQ</a>
                <a href="../html/forum.html" class="nav-link">Forum</a>
                <a href="../html/contactUs.html" class="nav-link">Contact</a>
                <a href="../controllers/PetController.php?id=1" class="nav-link active">My Pet</a>
                <a href="../html/login.html" class="nav-btn">Login</a>
            </div>
        </div>
    </nav>

    <div class="pet-profile-container">
        <div class="pet-header">
            <!-- Dynamic Image -->
            <?php if (!empty($pet->photo_url)): ?>
                <img src="<?php echo htmlspecialchars($pet->photo_url); ?>" alt="<?php echo htmlspecialchars($pet->name); ?>" class="pet-photo">
            <?php else: ?>
                <div class="pet-photo" style="display:flex;align-items:center;justify-content:center;color:#fff;background:#ccc;font-size:2rem;">
                    <?php echo strtoupper(substr($pet->name, 0, 1)); ?>
                </div>
            <?php endif; ?>
            
            <div class="pet-info">
                <h1><?php echo htmlspecialchars($pet->name); ?></h1>
                <p><?php echo htmlspecialchars($pet->breed); ?> &bull; <?php echo htmlspecialchars($pet->gender); ?> &bull; <?php echo htmlspecialchars($pet->age); ?> years old</p>
                <p>Status: <span class="<?php echo ($pet->is_active == 'Active' || $pet->is_active == 'yes') ? 'status-active' : 'status-inactive'; ?>"><?php echo htmlspecialchars($pet->is_active === 'yes' ? 'Active' : ($pet->is_active ?? 'Inactive')); ?></span></p>
            </div>
        </div>

        <div class="pet-details">
            <div class="detail-item">
                <span class="detail-label">Weight</span>
                <span class="detail-value"><?php echo htmlspecialchars($pet->weight); ?> kg</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Height</span>
                <span class="detail-value"><?php echo htmlspecialchars($pet->height); ?> cm</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Color</span>
                <span class="detail-value"><?php echo htmlspecialchars($pet->color); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Vaccination Status</span>
                <span class="detail-value"><?php echo htmlspecialchars($pet->vaccintation_status); ?></span>
            </div>
        </div>
    </div>

</body>
</html>
