<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "robot_arm");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

$conn->query("UPDATE robot_arm_status SET status = 0");


$result = $conn->query("SELECT id FROM robot_arm_status ORDER BY id DESC LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $id = $row['id'];
    if ($conn->query("UPDATE robot_arm_status SET status = 1 WHERE id = $id")) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No poses found']);
}

$conn->close();
