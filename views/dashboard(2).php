<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetStride | Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; overflow-x: hidden; color: #334155; }

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

        /* Navigation */
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
            height: 3rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
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
        @keyframes gradient-shift { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }

        .paw-container { position: fixed; inset: 0; overflow: hidden; pointer-events: none; z-index: 0; }
        .paw { position: absolute; font-size: 60px; opacity: 0.1; animation: float-paw 20s infinite ease-in-out; }
        @keyframes float-paw { 0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.1; } 50% { transform: translate(30px, -30px) rotate(180deg); opacity: 0.05; } }

        .heart { position: absolute; animation: floating 3s ease-in-out infinite; z-index: 0;}
        @keyframes floating { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .heart-1 { top: 40px; left: 40px; font-size: 48px; opacity: 0.2; }
        .heart-2 { top: 80px; right: 80px; font-size: 64px; opacity: 0.2; animation-delay: 1s; }

        /* Dashboard Layout */
        .dashboard-content {
            position: relative;
            z-index: 2;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.5);
            animation: fade-in 0.5s ease-out;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255,255,255,0.4);
            transition: transform 0.3s ease;
            animation: scale-in 0.5s ease-out;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.85);
        }

        h2 { font-size: 20px; color: #1e293b; margin-bottom: 15px; font-weight: 700; }
        h1.welcome-text { font-size: 24px; background: linear-gradient(135deg, #4365ff, #002fff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 800; }

        .stat-big { font-size: 36px; font-weight: 800; color: #334155; }
        .stat-label { font-size: 14px; color: #64748B; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;}

        .styled-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .styled-table th { text-align: left; padding: 12px; color: #64748B; font-size: 12px; text-transform: uppercase; border-bottom: 2px solid rgba(74, 159, 216, 0.2); }
        .styled-table td { padding: 15px 12px; font-size: 14px; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .styled-table tr:last-child td { border-bottom: none; }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }
        .status-Active, .status-Pending, .status-scheduled { background: #dbeafe; color: #1e40af; }
        .status-Completed, .status-completed, .status-finished { background: #dcfce7; color: #166534; }
        .status-InProgress, .status-in_progress { background: #fef3c7; color: #92400e; }

        .btn-action {
            background: linear-gradient(135deg, #4365ff, #002fff);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: opacity 0.3s;
        }
        .btn-action:hover { opacity: 0.9; }

        .submit-btn {
            background: linear-gradient(135deg, #4365ff, #002fff);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .submit-btn:hover { opacity: 0.9; transform: translateY(-2px); }

        .pet-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 15px; border: 2px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .pet-avatar.clickable { cursor: pointer; transition: all 0.3s; }
        .pet-avatar.clickable:hover { transform: scale(1.1); box-shadow: 0 6px 20px rgba(67, 101, 255, 0.4); border-color: #4365ff; }
        .flex-row { display: flex; align-items: center; }

        .logout-btn {
            background: #ff4757;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        .logout-btn:hover { opacity: 0.9; }

        @keyframes fade-in { 0% { opacity: 0; transform: translateY(10px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes scale-in { 0% { opacity: 0; transform: scale(0.95); } 100% { opacity: 1; transform: scale(1); } }

        /* 弹窗背景 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            align-items: center; justify-content: center;
        }
        /* 弹窗内容框 */
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            width: 90%;
            max-width: 400px;
            position: relative;
            text-align: center;
        }
        .close-btn {
            position: absolute; top: 10px; right: 15px;
            font-size: 24px; cursor: pointer;
        }
        /* 星星评分特效 */
        .star-rating {
            display: flex; flex-direction: row-reverse; justify-content: center;
            gap: 5px; margin: 15px 0;
        }
        .star-rating input { display: none; }
        .star-rating label { font-size: 30px; color: #ddd; cursor: pointer; }
        /* 鼠标悬停和选中时变黄 */
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #fdb64e; }
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
            <a href="landingPage.html" class="logo-link">
                <img src="../petstride-logo.png" alt="PetStride" class="nav-logo">
            </a>
            <div class="nav-links">
                <a href="#" class="nav-link">Home</a>
                <a href="../controller/JobController.php" class="nav-link">Jobs</a>
                <a href="../controller/ForumController.php" class="nav-link">Forum</a>
                <a href="../contactUs.html" class="nav-link">Contact</a>
                <a href="../faq.html" class="nav-link">FAQ</a>
                <a href="../controller/UserProfileController.php" class="nav-link">Settings</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-content">

        <header class="header-glass">
            <div>
                <h1 class="welcome-text">PetStride</h1>
                <p style="color: #64748B; font-size: 14px;">Welcome back, <?php echo htmlspecialchars($currentUser['first_name']); ?></p>
            </div>
            <div class="flex-row">
                <div style="text-align: right; margin-right: 15px;">
                    <div style="font-weight: 700; font-size: 14px;"><?php echo htmlspecialchars($currentUser['first_name'] . ' ' . ($currentUser['last_name'] ?? '')); ?></div>
                    <div style="font-size: 12px; color: #4A9FD8;"><?php echo ucfirst(htmlspecialchars($role)); ?></div>
                </div>
                <div style="width: 40px; height: 40px; background: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #4365ff; font-weight: bold; margin-right: 15px;">
                    <?php echo strtoupper(substr($currentUser['first_name'], 0, 1)); ?>
                </div>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </header>

        <?php if ($role === 'caregiver'): ?>

            <!-- Caregiver Dashboard -->
            <div class="grid-layout">
                <div class="glass-card">
                    <h2><span style="color:#4A9FD8">💰</span> Earnings</h2>
                    <div class="stat-big">$<?php echo number_format($stats['earnings'] ?? 0, 2); ?></div>
                    <div class="stat-label">Total Earned</div>
                </div>

                <div class="glass-card">
                    <h2><span style="color:#4A9FD8">📅</span> Schedule</h2>
                    <div class="stat-big"><?php echo $stats['pending_jobs'] ?? 0; ?></div>
                    <div class="stat-label">Upcoming Jobs</div>
                    <button class="submit-btn" onclick="window.location.href='../controller/JobController.php'">+ Explore Jobs</button>
                </div>

                <div class="glass-card">
                    <h2><span style="color:#4A9FD8">⭐</span> Overall Rating</h2>
                    <div class="stat-big"><?php echo number_format($stats['avg_rating'] ?? 0, 1); ?></div>
                    <div class="stat-label">Average Rating</div>
                    <p style="font-size: 12px; color: #64748B; margin-top: 10px;">
                        Based on <?php echo $stats['total_reviews'] ?? 0; ?> reviews
                    </p>
                </div>

                <div class="glass-card" style="grid-column: 1 / -1;">
                    <h2><span style="color:#4A9FD8">📋</span> Upcoming Schedule</h2>
                    <?php if (!empty($listItems)): ?>
                        <table class="styled-table">
                            <thead>
                            <tr>
                                <th>Pet</th>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($listItems as $job): ?>
                                <tr>
                                    <td>
                                        <div class="flex-row">
                                            <img src="<?php echo htmlspecialchars($job['photo_url'] ?? 'https://via.placeholder.com/50'); ?>" class="pet-avatar" alt="pet">
                                            <div>
                                                <strong><?php echo htmlspecialchars($job['pet_name'] ?? 'N/A'); ?></strong><br>
                                                <span style="font-size:12px; color:#94A3B8"><?php echo htmlspecialchars($job['breed'] ?? ''); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($job['client_name'] ?? 'N/A'); ?><br>
                                        <span style="font-size:12px; color:#94A3B8">📍 <?php echo htmlspecialchars($job['address'] ?? 'No address'); ?></span>
                                    </td>
                                    <td><span class="status-badge status-Pending"><?php echo htmlspecialchars($job['service_type'] ?? 'Service'); ?></span></td>
                                    <td><?php echo isset($job['start_time']) ? date('M d, H:i', strtotime($job['start_time'])) : 'TBD'; ?></td>
                                    <td><button class="btn-action" onclick="window.location.href='../controller/JobController.php'">View Details</button></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p style="padding: 20px; text-align: center; color: #94A3B8;">No upcoming jobs found.</p>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>

            <!-- Pet Owner Dashboard -->
            <div class="grid-layout">
                <div class="glass-card">
                    <h2><span style="color:#4A9FD8">🐾</span> My Pets</h2>
                    <?php if (!empty($pets)): ?>
                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            <?php foreach($pets as $pet): ?>
                                <div style="text-align: center;">
                                    <a href="PetProfileController.php?id=<?php echo $pet['id']; ?>" style="text-decoration: none;">
                                        <img src="<?php echo htmlspecialchars($pet['photo_url'] ?? 'https://via.placeholder.com/60'); ?>"
                                             class="pet-avatar clickable"
                                             style="width: 60px; height: 60px; margin: 0 auto 10px auto;">
                                    </a>
                                    <div style="font-weight: 600; font-size: 14px;"><?php echo htmlspecialchars($pet['name']); ?></div>
                                    <div style="font-size: 12px; color: #64748B;"><?php echo htmlspecialchars($pet['breed'] ?? ''); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="color: #94A3B8;">No pets added yet.</p>
                    <?php endif; ?>
                    <div style="margin-top: 20px; text-align: center;">
                        <button class="submit-btn" onclick="window.location.href='../controller/AddPetController.php'">+ Add New Pet</button>
                    </div>
                </div>

                <div class="glass-card">
                    <h2><span style="color:#4A9FD8">🗺️</span> Live Tracking</h2>
                    <div style="background: rgba(255,255,255,0.5); border-radius: 12px; height: 150px; display: flex; align-items: center; justify-content: center; border: 2px dashed #cbd5e1;">
                        <span style="color: #64748B; font-size: 14px;">📍 GPS Tracking Map</span>
                    </div>
                    <p style="font-size: 12px; color: #64748B; margin-top: 10px; text-align: center;">Real-time tracking coming soon</p>
                </div>

                <div class="glass-card">
                    <h2><span style="color:#4A9FD8">💳</span> Total Spent</h2>
                    <div class="stat-big">$<?php echo number_format($stats['total_spent'] ?? 0, 2); ?></div>
                    <div class="stat-label">Total Expenses</div>
                    <p style="font-size: 12px; color: #64748B; margin-top: 10px;">
                        <?php echo $stats['completed_jobs'] ?? 0; ?> completed services
                    </p>
                </div>

                <div class="glass-card" style="grid-column: 1 / -1;">
                    <h2><span style="color:#4A9FD8">📅</span> Activity History</h2>
                    <?php if (!empty($listItems)): ?>
                        <table class="styled-table">
                            <thead>
                            <tr>
                                <th>Service</th>
                                <th>Caregiver</th>
                                <th>Date</th>
                                <th>Cost</th>
                                <th>Status</th>
                                <th>Action</th> <!-- ✅ 1. 新增了 Action 列 -->
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($listItems as $job): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($job['service_type'] ?? 'Service'); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($job['caregiver_name'] ?? 'N/A'); ?><br>
                                        <?php if (!empty($job['phone'])): ?>
                                            <span style="font-size:12px; color:#94A3B8">📞 <?php echo htmlspecialchars($job['phone']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo isset($job['start_time']) ? date('M d, Y', strtotime($job['start_time'])) : 'TBD'; ?></td>
                                    <td style="font-weight: bold;">$<?php echo number_format($job['price'] ?? 0, 2); ?></td>
                                    <td>
                                    <span class="status-badge status-<?php echo str_replace(' ', '', htmlspecialchars($job['status'] ?? 'Pending')); ?>">
                                        <?php echo htmlspecialchars($job['status'] ?? 'Pending'); ?>
                                    </span>
                                    </td>
                                    <td>
                                        <!-- ✅ 2. 只有完成的订单才显示 Rate 按钮 -->
                                        <?php
                                        $status = strtolower($job['status'] ?? '');
                                        // 检查状态，并且确保有 job_id
                                        if (($status === 'completed' || $status === 'finished') && !empty($job['job_id'])):
                                            ?>
                                            <button class="submit-btn"
                                                    style="padding: 5px 15px; font-size: 12px; background: linear-gradient(135deg, #FF9F43, #FF6B6B);"
                                                    onclick="openRateModal(<?php echo $job['job_id']; ?>)"> <!-- ✅ 3. 传 job_id -->
                                                Rate
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p style="padding: 20px; text-align: center; color: #94A3B8;">No activity history yet.</p>
                        <button class="btn-action" onclick="window.location.href='../controller/JobController.php'">View Jobs</button>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<!-- ✅ 4. 评价弹窗表单 (使用 job_id) -->
<div id="ratingModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeRateModal()">&times;</span>
        <h2>Rate Your Experience</h2>

        <form id="ratingForm">
            <!-- 隐藏字段，name 改为 job_id -->
            <input type="hidden" name="job_id" id="modal_job_id">

            <div class="star-rating">
                <input type="radio" id="s5" name="stars" value="5"><label for="s5">★</label>
                <input type="radio" id="s4" name="stars" value="4"><label for="s4">★</label>
                <input type="radio" id="s3" name="stars" value="3"><label for="s3">★</label>
                <input type="radio" id="s2" name="stars" value="2"><label for="s2">★</label>
                <input type="radio" id="s1" name="stars" value="1"><label for="s1">★</label>
            </div>

            <textarea name="feedback" placeholder="Write your feedback here..."
                      style="width:100%; height:80px; margin-bottom:10px; padding:8px; border-radius:8px; border:1px solid #ccc;"></textarea>

            <button type="submit" class="submit-btn">Submit Rating</button>
        </form>
    </div>
</div>

<!-- ✅ 5. 控制脚本 -->
<script>
    const modal = document.getElementById('ratingModal');
    const inputId = document.getElementById('modal_job_id');

    // 打开弹窗，接收 job_id
    function openRateModal(id) {
        if(!id || id === 0) {
            alert("Error: Job ID not found.");
            return;
        }
        inputId.value = id; // 设置 hidden input 的值
        modal.style.display = 'flex';
    }

    // 关闭弹窗
    function closeRateModal() {
        modal.style.display = 'none';
        document.getElementById('ratingForm').reset(); // 重置表单
    }

    // 点击背景关闭
    window.onclick = function(event) {
        if (event.target == modal) {
            closeRateModal();
        }
    }

    // AJAX 提交表单
    document.getElementById('ratingForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        try {
            // 注意路径：指向刚才新建的 Controller
            const res = await fetch('../controller/RatingController.php', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();

            if (data.status === 'success') {
                alert(data.message);
                closeRateModal();
                // 刷新页面，以便更新状态（例如隐藏已评价的按钮）
                window.location.reload();
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error(error);
            alert('System error. Please try again.');
        }
    });
</script>

</body>
</html>