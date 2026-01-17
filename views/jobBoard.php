<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board - PetStride</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; overflow-x: hidden; background: #f8f9fa; }
        
        .container { min-height: 100vh; position: relative; overflow: hidden; }
        .background { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(242, 242, 242, 0.8) 0%, rgba(113, 154, 252, 0.8) 50%, rgba(242, 242, 242, 0.8) 100%); background-size: 400% 400%; animation: gradient-shift 15s ease infinite; }
        @keyframes gradient-shift { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        
        .paw-container { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
        .paw { position: absolute; font-size: 60px; opacity: 0.1; animation: float-paw 20s infinite ease-in-out; }
        @keyframes float-paw { 0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.1; } 50% { transform: translate(30px, -30px) rotate(180deg); opacity: 0.05; } }
        
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
        
        .content { position: relative; min-height: 100vh; padding: 40px 20px; }
        
        .header { max-width: 1200px; margin: 0 auto 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .header-left h1 { font-size: 32px; font-weight: 700; background: linear-gradient(135deg, #4365ff, #002fff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 8px; }
        .header-left p { color: #64748B; font-size: 14px; }
        .header-right { display: flex; gap: 12px; align-items: center; }
        
        .stats-card { background: linear-gradient(135deg, #4365ff, #002fff); color: white; padding: 16px 24px; border-radius: 12px; box-shadow: 0 4px 20px rgba(67, 101, 255, 0.3); }
        .stats-card .label { font-size: 12px; opacity: 0.9; margin-bottom: 4px; }
        .stats-card .value { font-size: 24px; font-weight: 700; }
        
        .btn { padding: 12px 24px; border: none; border-radius: 12px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-block; }
        .btn-primary { background: linear-gradient(135deg, #4365ff, #002fff); color: white; box-shadow: 0 4px 20px rgba(67, 101, 255, 0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 30px rgba(67, 101, 255, 0.4); }
        .btn-secondary { background: rgba(255, 255, 255, 0.9); color: #334155; border: 2px solid #E2E8F0; }
        .btn-secondary:hover { background: white; border-color: #4365ff; }
        
        .jobs-container { max-width: 1200px; margin: 0 auto; }
        
        .section-header { margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid rgba(67, 101, 255, 0.2); }
        .section-header h2 { font-size: 24px; color: #1e293b; font-weight: 700; }
        .section-header p { font-size: 14px; color: #64748b; margin-top: 4px; }
        
        .create-job-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); margin-bottom: 30px; animation: scale-in 0.5s ease-out; }
        @keyframes scale-in { 0% { opacity: 0; transform: scale(0.95); } 100% { opacity: 1; transform: scale(1); } }
        
        .create-job-card h2 { font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 20px; }
        
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .form-group { margin-bottom: 0; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-label { display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 8px; }
        .form-input, .form-select, .form-textarea { width: 100%; padding: 12px 16px; background: rgba(255, 255, 255, 0.7); border: 2px solid #E2E8F0; border-radius: 12px; font-size: 14px; transition: all 0.3s; font-family: inherit; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: #4365ff; box-shadow: 0 0 20px rgba(67, 101, 255, 0.2); }
        .form-textarea { resize: vertical; min-height: 100px; }
        .form-actions { display: flex; gap: 12px; margin-top: 20px; }
        
        .jobs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px; margin-bottom: 40px; }
        
        .job-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); transition: all 0.3s; animation: scale-in 0.5s ease-out; }
        .job-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12); }
        
        .job-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px; }
        .job-type { font-size: 18px; font-weight: 700; color: #1e293b; }
        .job-status { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-open { background: #dbeafe; color: #1e40af; }
        .status-confirmed { background: #d1fae5; color: #065f46; }
        .status-completed { background: #e0e7ff; color: #4338ca; }
        .status-declined { background: #fee2e2; color: #991b1b; }
        
        .pet-section { display: flex; gap: 16px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0; }
        .pet-photo { width: 80px; height: 80px; border-radius: 12px; object-fit: cover; background: #e2e8f0; }
        .pet-info { flex: 1; }
        .pet-name { font-size: 16px; font-weight: 600; color: #1e293b; margin-bottom: 4px; }
        .pet-breed { font-size: 14px; color: #64748b; margin-bottom: 8px; }
        .client-name { font-size: 14px; color: #4365ff; font-weight: 500; }
        
        .job-details { display: flex; flex-direction: column; gap: 12px; margin-bottom: 16px; }
        .detail-row { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #475569; }
        .detail-icon { width: 16px; height: 16px; color: #4365ff; }
        .detail-label { font-weight: 500; color: #334155; }
        
        .job-actions { display: flex; gap: 8px; margin-top: 16px; }
        .action-btn { flex: 1; padding: 10px; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .btn-accept { background: linear-gradient(135deg, #10b981, #059669); color: white; }
        .btn-accept:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4); }
        .btn-decline { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 2px solid #fee2e2; }
        .btn-decline:hover { background: rgba(239, 68, 68, 0.2); }
        .btn-complete { background: linear-gradient(135deg, #4365ff, #002fff); color: white; }
        .btn-complete:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(67, 101, 255, 0.4); }
        .btn-apply { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }
        .btn-apply:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4); }
        
        .success-message { max-width: 1200px; margin: 0 auto 20px; padding: 16px 24px; background: #d1fae5; color: #065f46; border-radius: 12px; font-weight: 500; animation: fade-in 0.5s ease-out; }
        .error-message { max-width: 1200px; margin: 0 auto 20px; padding: 16px 24px; background: #fee2e2; color: #991b1b; border-radius: 12px; font-weight: 500; animation: fade-in 0.5s ease-out; }
        @keyframes fade-in { 0% { opacity: 0; transform: translateY(-10px); } 100% { opacity: 1; transform: translateY(0); } }
        
        .empty-state { text-align: center; padding: 60px 20px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-radius: 16px; max-width: 500px; margin: 0 auto; }
        .empty-state h3 { font-size: 24px; color: #1e293b; margin-bottom: 12px; }
        .empty-state p { font-size: 16px; color: #64748b; margin-bottom: 24px; }
        
        .toggle-form-btn { margin-bottom: 20px; }
        .hidden { display: none; }
        
        @media (max-width: 768px) {
            .header { flex-direction: column; align-items: flex-start; }
            .header-left h1 { font-size: 24px; }
            .form-grid { grid-template-columns: 1fr; }
            .jobs-grid { grid-template-columns: 1fr; }
            .job-actions { flex-direction: column; }
        }
        .modal { position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 100; }
        .modal.hidden { display: none; }
        .modal-content { background: white; border-radius: 16px; padding: 30px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; }
    </style>
</head>
<body>
    <div class="container">
        <div class="background"></div>
        
        <div class="paw-container">
            <div class="paw" style="top: 10%; left: 15%;">🐾</div>
            <div class="paw" style="top: 60%; left: 5%;">🐾</div>
            <div class="paw" style="top: 30%; right: 10%;">🐾</div>
            <div class="paw" style="bottom: 20%; right: 20%;">🐾</div>
        </div>

        <!-- Navigation -->
        <nav class="nav">
            <div class="nav-content">
                <a href="landingPage.html" class="logo-link">
                    <img src="../petstride-logo.png" alt="PetStride" class="nav-logo">
                </a>
                <div class="nav-links">
                    <a href="../controller/DashboardController.php" class="nav-link">Home</a>
                    <a href="../faq.html" class="nav-link">FAQ</a>
                    <a href="../controller/ForumController.php" class="nav-link">Forum</a>
                    <a href="../contactUs.html" class="nav-link">Contact</a>
                </div>
            </div>
        </nav>

        <div class="content">
            <?php if (isset($success_message)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <div class="header">
                <div class="header-left">
                    <h1><?php echo $user_type === 'caregiver' ? 'Job Board' : 'My Bookings'; ?></h1>
                    <p><?php echo $user_type === 'caregiver' ? 'Find and manage pet care jobs' : 'Track your pet care bookings'; ?></p>
                </div>
                <div class="header-right">
                    <?php if ($user_type === 'caregiver'): ?>
                        <div class="stats-card">
                            <div class="label">Total Earnings</div>
                            <div class="value">$<?php echo number_format($total_earnings, 2); ?></div>
                        </div>
                    <?php endif; ?>
                    <a href="../controller/DashboardController.php" class="btn btn-secondary">← Dashboard</a>
                </div>
            </div>

            <div class="jobs-container">
                <!-- Caregiver Search & Filter -->
                <?php if ($user_type === 'caregiver'): ?>
                    <div style="margin-bottom: 30px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h3 style="margin: 0; color: #1e293b;">Find Jobs</h3>
                            <span style="font-size: 12px; color: #64748b;">Results update automatically</span>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 5px; display: block;">Keywords</label>
                                <input type="text" id="filter-keyword" oninput="applyFilters()" placeholder="Search location, breed..." 
                                       style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                            </div>
                            
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 5px; display: block;">Service Type</label>
                                <select id="filter-service" onchange="applyFilters()" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                                    <option value="all">All Services</option>
                                    <option value="Dog Walking">Dog Walking</option>
                                    <option value="Pet Sitting">Pet Sitting</option>
                                    <option value="Grooming">Grooming</option>
                                    <option value="Boarding">Boarding</option>
                                </select>
                            </div>

                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 5px; display: block;">Date</label>
                                <input type="date" id="filter-date" onchange="applyFilters()" min="<?php echo date('Y-m-d'); ?>"
                                       style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Pet Owner: Create Job Form -->
                <?php if ($user_type === 'pet_owner'): ?>
                    <button onclick="toggleJobForm()" class="btn btn-primary toggle-form-btn" id="toggleBtn">+ Create New Job</button>

                    <div id="jobForm" class="create-job-card hidden">
                        <h2>Create New Job</h2>
                        <form method="POST">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Select Pet *</label>
                                    <div style="display: flex; gap: 8px;">
                                        <select name="pet_id" class="form-select" required style="flex: 1;">
                                            <option value="">Choose a pet...</option>
                                            <?php foreach ($user_pets as $pet): ?>
                                                <option value="<?php echo $pet['id']; ?>">
                                                    <?php echo htmlspecialchars($pet['name']) . ' (' . htmlspecialchars($pet['breed']) . ')'; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="button" onclick="openPetModal()" class="btn btn-secondary" style="padding: 12px 16px; white-space: nowrap;">+ Add Pet</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Price ($) *</label>
                                    <input type="number" name="price" class="form-input" step="0.01" min="0" placeholder="0.00" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" class="form-input" placeholder="Service location">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Assign Caregiver (Optional)</label>
                                    <select name="caregiver_id" class="form-select">
                                        <option value="">Open for applications</option>
                                        <?php foreach ($available_caregivers as $caregiver): ?>
                                            <option value="<?php echo $caregiver['id']; ?>">
                                                <?php echo htmlspecialchars($caregiver['first_name'] . " " . $caregiver['last_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Start Date *</label>
                                    <input type="date" name="start_date" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Start Time *</label>
                                    <input type="time" name="start_time" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">End Date *</label>
                                    <input type="date" name="end_date" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">End Time *</label>
                                    <input type="time" name="end_time" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Service Type *</label>
                                    <select name="service_type" class="form-select" required>
                                        <option value="">Select service type...</option>
                                        <option value="Dog Walking">Dog Walking</option>
                                        <option value="Pet Sitting">Pet Sitting</option>
                                        <option value="Day Care">Day Care</option>
                                        <option value="Veterinary Visit">Veterinary Visit</option>
                                    </select> 
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="create_job" class="btn btn-primary">Create Job</button>
                                <button type="button" onclick="toggleJobForm()" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Caregiver: Open Jobs Section -->
                <?php if ($user_type === 'caregiver' && !empty($open_jobs)): ?>
                    <div class="section-header">
                        <h2>Available Jobs</h2>
                        <p>Browse and apply for open pet care jobs</p>
                    </div>
                    
                    <div class="jobs-grid" id="jobs-grid">
                        <?php foreach ($open_jobs as $job): ?>
                            <div class="job-card" 
                                 data-service="<?php echo htmlspecialchars($job['service_type']); ?>" 
                                 data-date="<?php echo date('Y-m-d', strtotime($job['start_time'])); ?>"
                                 data-location="<?php echo htmlspecialchars(strtolower($job['location'] ?? $job['address'])); ?>"
                                 data-breed="<?php echo htmlspecialchars(strtolower($job['breed'])); ?>">
                                 
                                <div class="job-header">
                                    <div class="job-type"><?php echo htmlspecialchars($job['service_type']); ?></div>
                                    <span class="job-status status-open">Open</span>
                                </div>

                                <div class="pet-section">
                                    <?php if (!empty($job['photo_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($job['photo_url']); ?>" alt="Pet photo" class="pet-photo">
                                    <?php else: ?>
                                        <div class="pet-photo"></div>
                                    <?php endif; ?>
                                    <div class="pet-info">
                                        <div class="pet-name"><?php echo htmlspecialchars($job['pet_name']); ?></div>
                                        <div class="pet-breed"><?php echo htmlspecialchars($job['breed']) . ', ' . htmlspecialchars($job['age']) . ' years'; ?></div>
                                        <div class="client-name"><?php echo htmlspecialchars($job['owner_name']); ?></div>
                                    </div>
                                </div>

                                <div class="job-details">
                                    <div class="detail-row">
                                        <span class="detail-icon">📅</span>
                                        <span class="detail-label">Start:</span>
                                        <span><?php echo date('M d, Y - g:i A', strtotime($job['start_time'])); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-icon">🏁</span>
                                        <span class="detail-label">End:</span>
                                        <span><?php echo date('M d, Y - g:i A', strtotime($job['end_time'])); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-icon">📍</span>
                                        <span class="detail-label">Location:</span>
                                        <span><?php echo htmlspecialchars($job['location'] ?? $job['address']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-icon">💰</span>
                                        <span class="detail-label">Payment:</span>
                                        <span style="font-weight: 700; color: #10b981;">$<?php echo number_format($job['price'], 2); ?></span>
                                    </div>
                                </div>

                                <form method="POST" class="job-actions" onsubmit="return checkOverlap(event, '<?php echo $job['start_time']; ?>', '<?php echo $job['end_time']; ?>')">
                                    <div class="overlap-error" style="width: 100%; color: #e53e3e; font-size: 13px; font-weight: bold; margin-bottom: 8px; display: none; background: #fee2e2; padding: 8px; border-radius: 8px;"></div>
                                    <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                    <button type="submit" name="action" value="apply" class="action-btn btn-apply">Apply for Job</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Pet Owner: Pending Applications Section -->
                <?php if ($user_type === 'pet_owner' && !empty($pending_applications)): ?>
                    <div class="section-header">
                        <h2>Pending Applications</h2>
                        <p>Review caregiver applications for your jobs</p>
                    </div>
                    
                    <div class="jobs-grid">
                        <?php foreach ($pending_applications as $app): ?>
                            <div class="job-card">
                                <div class="job-header">
                                    <div class="job-type"><?php echo htmlspecialchars($app['service_type'] ?: 'Job'); ?></div>
                                    <span class="job-status status-pending">Pending Review</span>
                                </div>

                                <div class="job-details">
                                    <div class="detail-row">
                                        <span class="detail-icon">🐕</span>
                                        <span class="detail-label">Pet:</span>
                                        <span><?php echo htmlspecialchars($app['pet_name']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-icon">👤</span>
                                        <span class="detail-label">Applicant:</span>
                                        <span><?php echo htmlspecialchars($app['caregiver_name']); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-icon">📅</span>
                                        <span class="detail-label">Date:</span>
                                        <span><?php echo date('M d, Y - g:i A', strtotime($app['start_time'])); ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-icon">💰</span>
                                        <span class="detail-label">Payment:</span>
                                        <span>$<?php echo number_format($app['price'], 2); ?></span>
                                    </div>
                                </div>

                                <form method="POST" class="job-actions">
                                    <input type="hidden" name="job_id" value="<?php echo $app['job_id']; ?>">
                                    <button type="submit" name="action" value="accept" class="action-btn btn-accept">Accept Application</button>
                                    <button type="submit" name="action" value="decline" class="action-btn btn-decline">Decline</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- My Jobs Section -->
                <?php if (!empty($jobs)): ?>
                    <div class="section-header">
                        <h2><?php echo $user_type === 'caregiver' ? 'My Assigned Jobs' : 'My Bookings'; ?></h2>
                        <p><?php echo $user_type === 'caregiver' ? 'Jobs you\'ve been assigned to' : 'Your scheduled pet care services'; ?></p>
                    </div>
                    
                    <div class="jobs-grid">
                        <?php foreach ($jobs as $job): ?>
                            <div class="job-card">
                                <div class="job-header">
                                    <div class="job-type"><?php echo htmlspecialchars($job['service_type'] ?: 'Job'); ?></div>
                                    <?php if (isset($job['status'])): ?>
                                        <span class="job-status status-<?php echo strtolower($job['status'] ?? 'pending'); ?>">
                                            <?php echo htmlspecialchars($job['status'] ?? 'Pending'); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($user_type === 'caregiver' && isset($job['pet_name'])): ?>
                                    <div class="pet-section">
                                        <?php if (!empty($job['photo_url'])): ?>
                                            <img src="<?php echo htmlspecialchars($job['photo_url']); ?>" alt="Pet photo" class="pet-photo">
                                        <?php else: ?>
                                            <div class="pet-photo"></div>
                                        <?php endif; ?>
                                        <div class="pet-info">
                                            <div class="pet-name"><?php echo htmlspecialchars($job['pet_name']); ?></div>
                                            <div class="pet-breed"><?php echo htmlspecialchars($job['breed']); ?></div>
                                            <div class="client-name"><?php echo htmlspecialchars($job['client_name']); ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="job-details">
                                    <div class="detail-row">
                                        <span class="detail-icon">📅</span>
                                        <span class="detail-label">Date:</span>
                                        <span><?php echo date('M d, Y - g:i A', strtotime($job['start_time'])); ?></span>
                                    </div>

                                    <?php if ($user_type === 'caregiver' && isset($job['address'])): ?>
                                        <div class="detail-row">
                                            <span class="detail-icon">📍</span>
                                            <span class="detail-label">Location:</span>
                                            <span><?php echo htmlspecialchars($job['location'] ?? $job['address']); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($user_type !== 'caregiver'): ?>
                                        <?php if (isset($job['caregiver_name']) && $job['caregiver_name']): ?>
                                            <div class="detail-row">
                                                <span class="detail-icon">👤</span>
                                                <span class="detail-label">Caregiver:</span>
                                                <span><?php echo htmlspecialchars($job['caregiver_name']); ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="detail-row">
                                                <span class="detail-icon">👤</span>
                                                <span class="detail-label">Caregiver:</span>
                                                <span style="color: #f59e0b;">Waiting for applications...</span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (isset($job['phone']) && $job['phone']): ?>
                                            <div class="detail-row">
                                                <span class="detail-icon">📞</span>
                                                <span class="detail-label">Phone:</span>
                                                <span><?php echo htmlspecialchars($job['phone']); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (isset($job['price'])): ?>
                                            <div class="detail-row">
                                                <span class="detail-icon">💰</span>
                                                <span class="detail-label">Price:</span>
                                                <span>$<?php echo number_format($job['price'], 2); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Chat Integration for Pet Owners -->
                                <?php if ($user_type === 'pet_owner'): ?>
                                    <div class="job-actions">
                                        <?php if (!empty($job['caregiver_id']) && $job['caregiver_id'] > 0 && !($job['status'] === 'completed' || $job['status'] === 'Declined')): ?>
                                            <a href="../controller/ChatController.php?job_id=<?php echo $job['id']; ?>" 
                                               class="action-btn btn-apply" 
                                               style="text-align: center; text-decoration: none; display: block;">
                                                💬 Message Caregiver
                                            </a>
                                        <?php elseif ($job['status'] === 'Open'): ?>
                                            <div style="text-align: center; padding: 10px; background: #fef3c7; color: #92400e; border-radius: 10px; font-size: 14px;">
                                                ⏳ Waiting for caregiver assignment
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (isset($job['status']) && ($job['status'] === 'Confirmed' || $job['status'] === 'Pending')): ?>
                                            <form method="POST" style="margin-top: 8px;">
                                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                                <button type="submit" 
                                                        name="action" 
                                                        value="cancel" 
                                                        class="action-btn btn-decline" 
                                                        style="width: 100%;"
                                                        onclick="return confirm('Are you sure you want to cancel this booking?');">
                                                    Cancel Booking
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Chat Integration for Caregivers -->
                                <?php if ($user_type === 'caregiver'): ?>
                                    <?php if (!isset($job['status']) || $job['status'] === 'Pending' || $job['status'] === null): ?>
                                        <form method="POST" class="job-actions">
                                            <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                            <button type="submit" name="action" value="accept" class="action-btn btn-accept">Accept</button>
                                            <button type="submit" name="action" value="decline" class="action-btn btn-decline">Decline</button>
                                        </form>
                                    <?php elseif ($job['status'] === 'Confirmed'): ?>
                                        <div class="job-actions">
                                            <a href="../controller/ChatController.php?job_id=<?php echo $job['id']; ?>" 
                                               class="action-btn btn-apply" 
                                               style="text-align: center; text-decoration: none; display: block;">
                                                💬 Message Client
                                            </a>
                                            <form method="POST" style="flex: 1;">
                                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                                <button type="submit" name="action" value="complete" class="action-btn btn-complete" style="width: 100%;">
                                                    Mark Complete
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php elseif ($user_type !== 'caregiver' || empty($open_jobs)): ?>
                    <div class="empty-state">
                        <h3>No Jobs Yet</h3>
                        <p><?php echo $user_type === 'caregiver' ? 'No jobs available at the moment. Check back soon!' : 'You haven\'t booked any services yet. Create your first job!'; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Pet Modal -->
    <div id="petModal" class="modal hidden">
        <div class="modal-content">
            <h2>Add New Pet</h2>
            <form id="petForm" onsubmit="submitPet(event)">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Name *</label>
                        <input type="text" name="pet_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Breed *</label>
                        <input type="text" name="pet_breed" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Age *</label>
                        <input type="number" name="pet_age" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gender *</label>
                        <select name="pet_gender" class="form-select" required>
                            <option value="">Choose...</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Add Pet</button>
                    <button type="button" onclick="closePetModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleJobForm() {
            const form = document.getElementById('jobForm');
            const btn = document.getElementById('toggleBtn');
            
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                btn.textContent = '✕ Cancel';
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                form.classList.add('hidden');
                btn.textContent = '+ Create New Job';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            const startDateInput = document.querySelector('input[name="start_date"]');
            const endDateInput = document.querySelector('input[name="end_date"]');
            
            if (startDateInput) {
                startDateInput.setAttribute('min', today);
            }
            
            if (endDateInput) {
                endDateInput.setAttribute('min', today);
            }
            
            if (startDateInput) {
                startDateInput.addEventListener('change', function() {
                    if (endDateInput) {
                        endDateInput.setAttribute('min', this.value);
                    }
                });
            }
        });

        function openPetModal() {
            document.getElementById('petModal').classList.remove('hidden');
        }

        function closePetModal() {
            document.getElementById('petModal').classList.add('hidden');
            document.getElementById('petForm').reset();
        }

        async function submitPet(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            formData.append('add_pet_ajax', '1');
            
            try {
                const response = await fetch('JobController.php', { method: 'POST', body: formData });
                const result = await response.json();
                
                if (result.success) {
                    const select = document.querySelector('select[name="pet_id"]');
                    const option = new Option(result.pet_name + ' (' + result.pet_breed + ')', result.pet_id, true, true);
                    select.add(option);
                    closePetModal();
                } else {
                    alert(result.message || 'Failed to add pet');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error: ' + error.message); 
            }
        }

        function applyFilters() {
            const keyword = document.getElementById('filter-keyword').value.toLowerCase();
            const service = document.getElementById('filter-service').value;
            const selectedDateStr = document.getElementById('filter-date').value;

            const cards = document.querySelectorAll('.job-card[data-service]');

            cards.forEach(card => {
                let show = true;

                if (service !== 'all' && card.dataset.service !== service) {
                    show = false;
                }

                if (selectedDateStr && card.dataset.date !== selectedDateStr) {
                    show = false;
                }

                if (keyword) {
                    const location = card.dataset.location || '';
                    const breed = card.dataset.breed || '';
                    if (!location.includes(keyword) && !breed.includes(keyword)) {
                        show = false;
                    }
                }

                card.style.display = show ? 'block' : 'none';
            });
        }

        const assignedJobs = <?php echo json_encode($user_type === 'caregiver' ? $jobs : []); ?>;

        function checkOverlap(event, newStartStr, newEndStr) {
            const newStart = new Date(newStartStr);
            const newEnd = new Date(newEndStr);

            const form = event.target;
            const errorDiv = form.querySelector('.overlap-error');
            if (errorDiv) {
                errorDiv.style.display = 'none';
                errorDiv.innerText = '';
            }

            for (const job of assignedJobs) {
                if (job.status === 'Completed' || job.status === 'Declined') continue;

                const currentStart = new Date(job.start_time);
                const currentEnd = job.end_time ? new Date(job.end_time) : new Date(currentStart.getTime() + 60 * 60 * 1000);

                if (newStart < currentEnd && newEnd > currentStart) {
                    event.preventDefault();
                    
                    if (errorDiv) {
                        const formatTime = (d) => d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        const msg = `⚠️ Time Conflict! You are busy from ${formatTime(currentStart)} to ${formatTime(currentEnd)}.`;
                        errorDiv.innerText = msg;
                        errorDiv.style.display = 'block';
                    }
                    
                    return false;
                }
            }
            
            return true;
        }
    </script>
</body>
</html>