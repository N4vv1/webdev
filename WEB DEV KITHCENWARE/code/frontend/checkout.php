<?php
session_start();
include('../backend/db/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Save the current URL
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./co.css">
    <title>Checkout</title>
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

    <!-- Checkout Section -->
    <section id="checkout">
        <h1>Checkout</h1>

        <!-- User Information Section -->
        <div class="user-info">
            <h2>Your Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_result['first_name'] . ' ' . $user_result['middle_name'] . ' ' . $user_result['last_name']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user_result['address']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user_result['contact_number']); ?></p>
        </div>

        <!-- Cart Items Section -->
        <div class="checkout-items">
            <?php while ($item = $cart_result->fetch_assoc()) {
                $item_total = $item['price'] * $item['quantity'];
                $total_amount += $item_total;
            ?>
                <div class="checkout-item">
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

        <div class="checkout-total">
            <h3>Total Amount: ₱ <?php echo number_format($total_amount, 2); ?></h3>
        </div>

        <!-- Payment Mode Section -->
        <div class="payment-method">
            <h2>Select Payment Method</h2>
            <form action="process_payment.php" method="POST">
                <label for="payment_method">Choose payment method:</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="cash_on_delivery">Cash on Delivery (COD)</option>
                    <option value="credit_card">Credit Card</option>
                </select>
                <button type="submit" class="btn btn-primary">Proceed to Payment</button>
            </form>
        </div>

        <!-- Checkout Actions -->
        <div class="checkout-actions">
            <a href="cart.php" class="btn">Back to Cart</a>
        </div>
    </section>
</body>
</html>
