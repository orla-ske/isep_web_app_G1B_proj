<?php
// controller/AdminFAQController.php

session_start();
require_once '../model/connection.php';
require_once '../model/adminModel.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: ../login.html");
    exit();
}

$conn = $pdo;
$adminModel = new AdminModel($conn);

$currentUser = array(
    'id' => $_SESSION['user_id'],
    'first_name' => $_SESSION['first_name'] ?? 'Admin',
    'last_name' => $_SESSION['last_name'] ?? '',
    'role' => $_SESSION['role']
);

// Handle actions
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $data = array(
                    'question' => $_POST['question'],
                    'answer' => $_POST['answer'],
                    'category' => $_POST['category'],
                    'display_order' => intval($_POST['display_order']),
                    'is_active' => isset($_POST['is_active']) ? 1 : 0,
                    'created_by' => $currentUser['id']
                );
                
                if ($adminModel->createFAQ($data)) {
                    $adminModel->logActivity(
                        $currentUser['id'],
                        'create',
                        'faq',
                        mysqli_insert_id($conn),
                        'Created new FAQ entry'
                    );
                    $message = 'FAQ created successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to create FAQ.';
                    $messageType = 'error';
                }
                break;
                
            case 'update':
                $faqId = intval($_POST['faq_id']);
                $data = array(
                    'question' => $_POST['question'],
                    'answer' => $_POST['answer'],
                    'category' => $_POST['category'],
                    'display_order' => intval($_POST['display_order']),
                    'is_active' => isset($_POST['is_active']) ? 1 : 0
                );
                
                if ($adminModel->updateFAQ($faqId, $data)) {
                    $adminModel->logActivity(
                        $currentUser['id'],
                        'update',
                        'faq',
                        $faqId,
                        'Updated FAQ entry'
                    );
                    $message = 'FAQ updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to update FAQ.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete':
                $faqId = intval($_POST['faq_id']);
                
                if ($adminModel->deleteFAQ($faqId)) {
                    $adminModel->logActivity(
                        $currentUser['id'],
                        'delete',
                        'faq',
                        $faqId,
                        'Deleted FAQ entry'
                    );
                    $message = 'FAQ deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to delete FAQ.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get filters
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

// Get FAQs
$faqs = $adminModel->getAllFAQs($categoryFilter);
$categories = $adminModel->getFAQCategories();

// Get single FAQ if editing
$editFAQ = null;
if (isset($_GET['edit'])) {
    $editFAQ = $adminModel->getFAQById(intval($_GET['edit']));
}

// Show create form
$showCreate = isset($_GET['create']);

// Include the view
include '../view/admin_faq_view.php';
?>