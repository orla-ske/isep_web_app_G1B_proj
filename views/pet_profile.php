<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pet->name); ?> - Pet Profile</title>
    <!-- Assuming we might use the style from existing css or a new one -->
    <link rel="stylesheet" href="../Style/about_us.css"> 
    <style>
        .pet-profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .pet-header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .pet-photo {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 30px;
            background-color: #ddd; /* Placeholder color */
        }
        .pet-info h1 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .pet-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .detail-item {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
        }
        .detail-label {
            font-weight: bold;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-inactive {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Header/Nav placeholder (could be included) -->
    <nav>
        <a href="../html/landingPage.html">Home</a>
    </nav>

    <div class="pet-profile-container">
        <div class="pet-header">
            <?php if (!empty($pet->photo_url)): ?>
                <img src="<?php echo htmlspecialchars($pet->photo_url); ?>" alt="<?php echo htmlspecialchars($pet->name); ?>" class="pet-photo">
            <?php else: ?>
                <div class="pet-photo" style="display:flex;align-items:center;justify-content:center;color:#fff;background:#ccc;">No Photo</div>
            <?php endif; ?>
            
            <div class="pet-info">
                <h1><?php echo htmlspecialchars($pet->name); ?></h1>
                <p><?php echo htmlspecialchars($pet->breed); ?> &bull; <?php echo htmlspecialchars($pet->gender); ?> &bull; <?php echo $pet->age; ?> years old</p>
                <p>Status: <span class="<?php echo ($pet->is_active == 'Active') ? 'status-active' : 'status-inactive'; ?>"><?php echo htmlspecialchars($pet->is_active ?? 'Unknown'); ?></span></p>
            </div>
        </div>

        <div class="pet-details">
            <div class="detail-item">
                <span class="detail-label">Weight</span>
                <?php echo htmlspecialchars($pet->weight); ?> kg
            </div>
            <div class="detail-item">
                <span class="detail-label">Height</span>
                <?php echo htmlspecialchars($pet->height); ?> cm
            </div>
            <div class="detail-item">
                <span class="detail-label">Color</span>
                <?php echo htmlspecialchars($pet->color); ?>
            </div>
            <div class="detail-item">
                <span class="detail-label">Vaccination Status</span>
                <?php echo htmlspecialchars($pet->vaccintation_status); ?>
            </div>
        </div>
    </div>

</body>
</html>
