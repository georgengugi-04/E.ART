<?php
session_start();
require_once "connect.php";

// Redirect if not logged in
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
$sql = "SELECT c.quantity, p.name, p.price, (c.quantity * p.price) AS total
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$grand_total = 0;

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $grand_total += $row['total'];
}

$stmt->close(); // Close prepared statement
$conn->close(); // Close the connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Safari Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Checkout</h1>

        <?php if (empty($cart_items)): ?>
            <p class="text-gray-600">Your cart is empty. Please add items to the cart before proceeding.</p>
            <a href="login.php" class="text-blue-500 hover:underline">Continue Shopping</a>
        <?php else: ?>
            <table class="w-full mb-4 border">
                <thead class="bg-orange-100">
                    <tr>
                        <th class="text-left p-2">Product</th>
                        <th class="text-right p-2">Quantity</th>
                        <th class="text-right p-2">Price</th>
                        <th class="text-right p-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                    <tr class="border-b">
                        <td class="p-2"><?php echo htmlspecialchars($item['name']); ?></td>
                        <td class="p-2 text-right"><?php echo $item['quantity']; ?></td>
                        <td class="p-2 text-right">KSh <?php echo number_format($item['price'], 2); ?></td>
                        <td class="p-2 text-right">KSh <?php echo number_format($item['total'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-right text-lg font-semibold mb-4">
                Grand Total: KSh <?php echo number_format($grand_total, 2); ?>
            </div>

            <form action="place_order.php" method="POST">
                <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-lg font-bold hover:bg-orange-600 transition duration-200">
                    Place Order
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
