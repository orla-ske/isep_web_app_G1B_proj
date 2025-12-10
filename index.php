<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/connection.php';
require_once 'controllers/DashboardController.php';

$controller = new DashboardController();
$controller->index();
?>