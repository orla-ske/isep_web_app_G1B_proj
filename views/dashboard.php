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
        .background { position: absolute; inset: 0; background: linear-gradient(135deg, rgb(242, 242, 242, 0.8) 0%, rgba(113, 154, 252, 0.8) 50%, rgb(242, 242, 242, 0.8) 100%); background-size: 400% 400%; animation: gradient-shift 15s ease infinite; z-index: -1; position: fixed;}
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
        h1.welcome-text { font-size: 24px; background: linear-gradient(135deg, #4365ff, #002fff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800; }
        
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
        .status-Active, .status-Pending { background: #dbeafe; color: #1e40af; }
        .status-Completed { background: #dcfce7; color: #166534; }
        
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

        @keyframes fade-in { 0% { opacity: 0; transform: translateY(10px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes scale-in { 0% { opacity: 0; transform: scale(0.95); } 100% { opacity: 1; transform: scale(1); } }
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

    <div class="dashboard-content">
        
        <header class="header-glass">
            <div>
                <h1 class="welcome-text">PetStride</h1>
                <p style="color: #64748B; font-size: 14px;">Welcome back, <?php echo htmlspecialchars($currentUser['first_name']); ?></p>
            </div>
            <div class="flex-row">
                <div style="text-align: right; margin-right: 15px;">
                    <div style="font-weight: 700; font-size: 14px;"><?php echo htmlspecialchars($currentUser['first_name']); ?></div>
                    <div style="font-size: 12px; color: #4A9FD8;"><?php echo ucfirst(htmlspecialchars($role)); ?></div>
                </div>
                <div style="width: 40px; height: 40px; background: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #4365ff; font-weight: bold; margin-right: 15px;">
                    <?php echo substr($currentUser['first_name'], 0, 1); ?>
                </div>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </header>

        <?php if ($role === 'caregiver'): ?>
        
        <div class="grid-layout">
            <div class="glass-card">
                <h2><span style="color:#4A9FD8">💰</span> Earnings</h2>
                <div class="stat-big">$<?php echo number_format($stats['earnings'], 2); ?></div>
                <div class="stat-label">Total Earned</div>
            </div>

            <div class="glass-card">
                <h2><span style="color:#4A9FD8">📅</span> Schedule</h2>
                <div class="stat-big"><?php echo $stats['pending_jobs']; ?></div>
                <div class="stat-label">Upcoming Jobs</div>
            </div>

            <div class="glass-card" style="grid-column: 1 / -1;">
                <h2><span style="color:#4A9FD8">📋</span> Upcoming Schedule</h2>
                <?php if (count($listItems) > 0): ?>
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
                                        <img src="<?php echo $job['photo_url'] ?? 'https://via.placeholder.com/50'; ?>" class="pet-avatar" alt="pet">
                                        <div>
                                            <strong><?php echo htmlspecialchars($job['pet_name']); ?></strong><br>
                                            <span style="font-size:12px; color:#94A3B8"><?php echo htmlspecialchars($job['breed']); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($job['client_name']); ?><br>
                                    <span style="font-size:12px; color:#94A3B8">📍 <?php echo htmlspecialchars($job['address']); ?></span>
                                </td>
                                <td><span class="status-badge status-Pending"><?php echo htmlspecialchars($job['service_type']); ?></span></td>
                                <td><?php echo date('M d, H:i', strtotime($job['start_time'])); ?></td>
                                <td><button class="btn-action" onclick="startJob(<?php echo $job['id']; ?>)">Start Job</button></td>
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

        <div class="grid-layout">
            <div class="glass-card">
                <h2><span style="color:#4A9FD8">🐾</span> My Pets</h2>
                <?php if (count($pets) > 0): ?>
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <?php foreach($pets as $pet): ?>
                            <div style="text-align: center;">
                                <img src="<?php echo $pet['photo_url'] ?? 'https://via.placeholder.com/60'; ?>" class="pet-avatar" style="width: 60px; height: 60px; margin: 0 auto 10px auto;">
                                <div style="font-weight: 600; font-size: 14px;"><?php echo htmlspecialchars($pet['name']); ?></div>
                                <div style="font-size: 12px; color: #64748B;"><?php echo htmlspecialchars($pet['breed']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color: #94A3B8;">No pets added yet.</p>
                <?php endif; ?>
                <div style="margin-top: 20px; text-align: center;">
                    <button class="submit-btn" onclick="window.location.href='add-pet.php'">+ Add New Pet</button>
                </div>
            </div>

            <div class="glass-card">
                <h2><span style="color:#4A9FD8">🗺️</span> Live Tracking</h2>
                <div style="background: rgba(255,255,255,0.5); border-radius: 12px; height: 150px; display: flex; align-items: center; justify-content: center; border: 2px dashed #cbd5e1;">
                    <span style="color: #64748B; font-size: 14px;">📍 GPS Tracking Map</span>
                </div>
                <p style="font-size: 12px; color: #64748B; margin-top: 10px; text-align: center;">Real-time GPS data from Device ID 102</p>
            </div>

            <div class="glass-card" style="grid-column: 1 / -1;">
                <h2><span style="color:#4A9FD8">📅</span> Activity History</h2>
                <?php if (count($listItems) > 0): ?>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Caregiver</th>
                                <th>Date</th>
                                <th>Cost</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($listItems as $job): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($job['service_type']); ?></td>
                                <td><?php echo htmlspecialchars($job['caregiver_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($job['start_time'])); ?></td>
                                <td style="font-weight: bold;">$<?php echo htmlspecialchars($job['price']); ?></td>
                                <td><span class="status-badge status-<?php echo $job['status']; ?>"><?php echo $job['status']; ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="padding: 20px; text-align: center; color: #94A3B8;">No activity history yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <?php endif; ?>

    </div>
</div>

<script>
function startJob(jobId) {
    if (!confirm('Start this job?')) return;
    
    const formData = new FormData();
    formData.append('job_id', jobId);
    
    fetch('controllers/DashboardController.php?action=start_job', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Job started successfully!');
            location.reload();
        } else {
            alert('Failed to start job: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}
</script>

</body>
</html>