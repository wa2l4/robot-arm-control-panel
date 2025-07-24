<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "robot_arm");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'DB Connection failed']);
    exit;
}

$sql = "INSERT INTO robot_arm_status (motor1, motor2, motor3, motor4, motor5, motor6, status)
        VALUES (0, 0, 0, 0, 0, 0, 0)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>
