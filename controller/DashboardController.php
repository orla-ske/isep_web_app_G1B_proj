<?php
require_once 'models/User.php';
require_once 'models/Job.php';
require_once 'models/Pet.php';

class DashboardController {
    private $db;
    private $userModel;
    private $jobModel;
    private $petModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->userModel = new User($this->db);
        $this->jobModel = new Job($this->db);
        $this->petModel = new Pet($this->db);
    }

    public function index() {
        $current_user_id = $_SESSION['user_id'];
        
        // Get current user data
        $currentUser = $this->userModel->getUserById($current_user_id);
        
        if (!$currentUser) {
            die("<div style='color:white; padding:20px'>User not found.</div>");
        }

        $role = $currentUser['role'];
        $stats = [];
        $listItems = [];
        $pets = [];

        if ($role === 'caregiver') {
            // Caregiver dashboard data
            $stats['earnings'] = $this->jobModel->getCaregiverEarnings($current_user_id);
            $listItems = $this->jobModel->getCaregiverUpcomingJobs($current_user_id);
            $stats['pending_jobs'] = count($listItems);
            
        } else {
            // Pet owner dashboard data
            $pets = $this->petModel->getUserPets($current_user_id);
            $stats['total_pets'] = count($pets);
            $listItems = $this->jobModel->getOwnerJobs($current_user_id);
        }

        // Load the view
        require_once 'views/dashboard.php';
    }

    public function startJob() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $job_id = $_POST['job_id'] ?? null;
            
            if ($job_id) {
                $result = $this->jobModel->updateJobStatus($job_id, 'In Progress');
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Job started']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to start job']);
                }
            }
        }
    }
}

// AJAX Handler
if (isset($_GET['action'])) {
    $controller = new DashboardController();
    
    if ($_GET['action'] === 'start_job') {
        $controller->startJob();
    }
    exit;
}
?>