<?php
session_start();
include('../backend/db/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login/login.php");
    exit();
}

// Fetch cart items
$cart_query = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$cart_result = $stmt->get_result();

// Fetch user's information
$user_query = "SELECT * FROM user_info WHERE user_id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$user_result = $stmt->get_result()->fetch_assoc();

// Calculate total amount
$total_amount = 0;
while ($item = $cart_result->fetch_assoc()) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Payment method from the previous form submission
$payment_method = $_SESSION['payment_method']; // Storing payment method in session for confirmation

// Estimate delivery time based on payment method
if ($payment_method === 'cash_on_delivery') {
    $delivery_time = "3-5 business days";
} else {
    $delivery_time = "1-3 business days (after payment confirmation)";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./oc.css">
    <title>Order Confirmation</title>
</head>
<body>
    <!-- Header Section -->
    <section id="header">
        <a href="#"><img src="../../pics/logo.png" class="logo" alt="Logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">HOME</a></li>
                <li><a href="shop.php">SHOP</a></li>
                <li><a href="about.php">ABOUT US</a></li>
                <li><a href="contact.php">CONTACT</a></li>
                <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="./userprofile/profile.php"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

    <!-- Order Confirmation Section -->
    <section id="confirmation">
        <h1>Order Confirmation</h1>

        <!-- User Information Section -->
        <div class="user-info">
            <h2>Your Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_result['first_name'] . ' ' . $user_result['middle_name'] . ' ' . $user_result['last_name']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user_result['address']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user_result['contact_number']); ?></p>
        </div>

        <!-- Cart Items Section -->
        <div class="order-items">
            <?php
            $cart_result->data_seek(0); // Reset the result pointer
            while ($item = $cart_result->fetch_assoc()) {
                $item_total = $item['price'] * $item['quantity'];
            ?>
                <div class="order-item">
                    <!-- Product Image -->
                    <div class="product-image">
                        <img src="../backend/uploads/<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" />
                    </div>
                    <!-- Product Info -->
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                        <p>Price per item: ₱ <?php echo number_format($item['price'], 2); ?></p>
                        <p>Total: ₱ <?php echo number_format($item_total, 2); ?></p>
                    </div>
                </div>
                <hr>
            <?php } ?>
        </div>

        <div class="order-total">
            <h3>Total Amount: ₱ <?php echo number_format($total_amount, 2); ?></h3>
        </div>

        <!-- Payment Method Section -->
        <div class="payment-method">
            <h2>Payment Method</h2>
            <p><?php echo ucfirst(str_replace('_', ' ', $payment_method)); ?></p>
        </div>

        <!-- Delivery Time Section -->
        <div class="delivery-time">
            <h2>Estimated Delivery Time</h2>
            <p>Your order will be delivered within <?php echo $delivery_time; ?>.</p>
        </div>

        <!-- Confirmation Action -->
        <div class="confirmation-actions">
            <a href="index.php" class="btn">Go to Home</a>
            <a href="shop.php" class="btn">Continue Shopping</a>
        </div>
    </section>
</body>
</html>
