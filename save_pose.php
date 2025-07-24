<?php
$data = json_decode(file_get_contents('php://input'), true);
$motors = $data['motors'] ?? null;

header('Content-Type: application/json');

if (!$motors || count($motors) !== 6) {
    echo json_encode(['success' => false, 'error' => 'Invalid motors data']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "robot_arm");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO robot_arm_status (motor1, motor2, motor3, motor4, motor5, motor6, status) VALUES (?, ?, ?, ?, ?, ?, 0)");
$stmt->bind_param("iiiiii", $motors[0], $motors[1], $motors[2], $motors[3], $motors[4], $motors[5]);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
$stmt->close();
$conn->close();
