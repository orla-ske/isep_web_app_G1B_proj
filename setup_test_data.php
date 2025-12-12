<?php
require_once 'model/connection.php';

try {
    echo "<h1>Setting up Test Data...</h1>";

    // 1. Create Caregiver
    $caregiverEmail = 'caregiver_test@example.com';
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$caregiverEmail]);
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role, city, address) VALUES ('Test', 'Caregiver', ?, 'password', 'caregiver', 'TestCity', '123 Caregiver Lane')");
        $stmt->execute([$caregiverEmail]);
        echo "Created Caregiver: $caregiverEmail / password<br>";
    } else {
        echo "Caregiver already exists.<br>";
    }
    
    // Get Caregiver ID
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$caregiverEmail]);
    $caregiverId = $stmt->fetchColumn();

    // 2. Create Pet Owner
    $ownerEmail = 'owner_test@example.com';
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$ownerEmail]);
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role, city, address) VALUES ('Test', 'Owner', ?, 'password', 'pet_owner', 'TestCity', '456 Owner St')");
        $stmt->execute([$ownerEmail]);
        echo "Created Pet Owner: $ownerEmail / password<br>";
    } else {
        echo "Pet Owner already exists.<br>";
    }

    // Get Owner ID
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$ownerEmail]);
    $ownerId = $stmt->fetchColumn();

    // 3. Create Pet
    $petName = 'TestDog';
    $stmt = $pdo->prepare("SELECT id FROM Pet WHERE name = ? AND Users_id = ?");
    $stmt->execute([$petName, $ownerId]);
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO Pet (name, breed, age, Users_id, photo_url) VALUES (?, 'Golden Retriever', 3, ?, 'https://via.placeholder.com/150')");
        $stmt->execute([$petName, $ownerId]);
        echo "Created Pet: $petName<br>";
    } else {
        echo "Pet already exists.<br>";
    }
    $petId = $pdo->lastInsertId();
    if (!$petId) {
        $stmt = $pdo->prepare("SELECT id FROM Pet WHERE name = ? AND Users_id = ?");
        $stmt->execute([$petName, $ownerId]);
        $petId = $stmt->fetchColumn();
    }

    // 4. Create Open Job
    // Check if open job exists for this user
    $stmt = $pdo->prepare("SELECT id FROM Job WHERE user_id = ? AND caregiver_id IS NULL");
    $stmt->execute([$ownerId]);
    if ($stmt->rowCount() == 0) {
        $startTime = date('Y-m-d H:i:s', strtotime('+1 day 10:00:00'));
        $endTime = date('Y-m-d H:i:s', strtotime('+1 day 12:00:00'));
        // Using `Payment_id` 1 as placeholder since schema requires it
        $stmt = $pdo->prepare("INSERT INTO Job (location, user_id, pet_id, price, status, service_type, start_time, end_time, Payment_id) VALUES ('Central Park, NY', ?, ?, 50.00, 'Pending', 'Dog Walking', ?, ?, 1)");
        $stmt->execute([$ownerId, $petId, $startTime, $endTime]);
        echo "Created Open Job for $petName in Central Park, NY<br>";
    } else {
        echo "Open Job already exists.<br>";
    }

    echo "<h2>Setup Complete!</h2>";
    echo "<p>You can now use these credentials to test the search functionality.</p>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>