<?php
session_start();
require_once "connect.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Connect to DB
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch cart items
$sql = "SELECT c.product_id, c.quantity, p.price 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_amount = 0;

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_amount += $row['quantity'] * $row['price'];
}

// If cart is empty
if (empty($cart_items)) {
    echo "Your cart is empty. <a href='cart.php'>Go back to cart</a>";
    exit;
}

// Begin transaction
$conn->begin_transaction();

try {
    // Insert into orders table
    $order_sql = "INSERT INTO orders (user_id, total_amount, created_at) VALUES (?, ?, NOW())";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->bind_param("id", $user_id, $total_amount);
    $order_stmt->execute();
    $order_id = $conn->insert_id;

    // Insert into order_items
    $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $item_stmt = $conn->prepare($item_sql);

    foreach ($cart_items as $item) {
        $item_stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $item_stmt->execute();
    }

    // Clear user's cart
    $clear_cart_sql = "DELETE FROM cart WHERE user_id = ?";
    $clear_stmt = $conn->prepare($clear_cart_sql);
    $clear_stmt->bind_param("i", $user_id);
    $clear_stmt->execute();

    // Commit transaction
    $conn->commit();

    echo "<h2>Order placed successfully!</h2>";
    echo "<p>Order ID: #" . $order_id . "</p>";
    echo "<a href='shop.php'>Continue Shopping</a>";

} catch (Exception $e) {
    $conn->rollback();
    echo "Failed to place order: " . $e->getMessage();
}

$conn->close();
?>
