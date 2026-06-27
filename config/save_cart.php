<?php
session_start();
require_once "connect.php";

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (!is_array($input)) {
    echo json_encode(["success" => false, "message" => "Invalid data."]);
    exit;
}

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

foreach ($input as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE quantity = quantity + ?");
    $stmt->bind_param("iiii", $user_id, $product_id, $quantity, $quantity);
    $stmt->execute();
}

echo json_encode(["success" => true]);
