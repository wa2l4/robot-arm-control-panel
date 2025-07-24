<?php
header('Content-Type: application/json');

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['error' => 'Invalid ID']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "robot_arm");
if ($conn->connect_error) {
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}

$stmt = $conn->prepare("SELECT motor1, motor2, motor3, motor4, motor5, motor6 FROM robot_arm_status WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Pose not found']);
}

$stmt->close();
$conn->close();
