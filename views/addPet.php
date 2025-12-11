<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Pet - PetStride</title>
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.9);
            --text-main: #333;
            --text-muted: #666;
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
            position: relative;
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

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h1 {
            font-size: 32px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 16px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
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

        .form-input, .form-select {
            width: 100%;
            padding: 14px 18px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            color: #2d3748;
            outline: none;
            transition: all 0.3s;
            font-family: inherit;
        }

        .form-input:focus, .form-select:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.1);
            background-color: white;
        }

        .photo-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .photo-upload-area:hover {
            border-color: #764ba2;
            background: rgba(118, 75, 162, 0.05);
        }

        .photo-upload-area input[type="file"] {
            display: none;
        }

        .photo-preview {
            margin-top: 15px;
            display: none;
        }

        .photo-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .error-alert {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .error-alert ul {
            margin-left: 20px;
            margin-top: 10px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 30px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            text-decoration: none;
            display: inline-block;
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

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="background"></div>
    
    <div class="container">
        <div class="form-card">
            <div class="form-header">
                <h1>🐾 Add New Pet</h1>
                <p>Fill in your pet's information below</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="error-alert">
                    <strong>⚠️ Please fix the following errors:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <!-- Pet Name -->
                    <div class="form-group">
                        <label>Pet Name <span>*</span></label>
                        <input type="text" name="name" class="form-input" 
                               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" 
                               placeholder="e.g., Buddy" required>
                    </div>

                    <!-- Breed -->
                    <div class="form-group">
                        <label>Breed <span>*</span></label>
                        <input type="text" name="breed" class="form-input" 
                               value="<?php echo htmlspecialchars($_POST['breed'] ?? ''); ?>" 
                               placeholder="e.g., Golden Retriever" required>
                    </div>

                    <!-- Age -->
                    <div class="form-group">
                        <label>Age (years) <span>*</span></label>
                        <input type="number" name="age" class="form-input" min="0" max="30"
                               value="<?php echo htmlspecialchars($_POST['age'] ?? ''); ?>" 
                               placeholder="e.g., 3" required>
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label>Gender <span>*</span></label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select gender</option>
                            <option value="Male" <?php echo ($_POST['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($_POST['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>

                    <!-- Weight -->
                    <div class="form-group">
                        <label>Weight (kg) <span>*</span></label>
                        <input type="number" name="weight" class="form-input" min="0" step="0.1"
                               value="<?php echo htmlspecialchars($_POST['weight'] ?? ''); ?>" 
                               placeholder="e.g., 25.5" required>
                    </div>

                    <!-- Height -->
                    <div class="form-group">
                        <label>Height (cm)</label>
                        <input type="number" name="height" class="form-input" min="0" step="0.1"
                               value="<?php echo htmlspecialchars($_POST['height'] ?? ''); ?>" 
                               placeholder="e.g., 60">
                    </div>

                    <!-- Color -->
                    <div class="form-group">
                        <label>Color</label>
                        <input type="text" name="color" class="form-input" 
                               value="<?php echo htmlspecialchars($_POST['color'] ?? ''); ?>" 
                               placeholder="e.g., Golden Brown">
                    </div>

                    <!-- Vaccination Status -->
                    <div class="form-group">
                        <label>Vaccination Status</label>
                        <select name="vaccintation_status" class="form-select">
                            <option value="Up to date" <?php echo ($_POST['vaccintation_status'] ?? '') === 'Up to date' ? 'selected' : ''; ?>>Up to date</option>
                            <option value="Pending" <?php echo ($_POST['vaccintation_status'] ?? '') === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="Unknown" <?php echo ($_POST['vaccintation_status'] ?? '') === 'Unknown' ? 'selected' : ''; ?>>Unknown</option>
                        </select>
                    </div>

                    <!-- Photo Upload -->
                    <div class="form-group full-width">
                        <label>Pet Photo</label>
                        <label for="photo-input" class="photo-upload-area">
                            <div>
                                <div style="font-size: 48px; margin-bottom: 10px;">📸</div>
                                <div style="font-weight: 600; color: #764ba2;">Click to upload photo</div>
                                <div style="font-size: 14px; color: #94a3b8; margin-top: 5px;">PNG, JPG or GIF (MAX. 5MB)</div>
                            </div>
                            <input type="file" id="photo-input" name="photo" accept="image/*">
                            <div class="photo-preview" id="photo-preview">
                                <img id="preview-image" src="" alt="Preview">
                            </div>
                        </label>
                    </div>
                </div>

                <div class="button-group">
                    <a href="../controller/DashboardController.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Pet</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo preview
        document.getElementById('photo-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('photo-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>