<?php
session_start();
include('../backend/db/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Save the current URL
    header("Location: ../../../login/login.php");
    exit();
}

// Handle cart actions: increase, decrease, or remove
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        if (isset($_POST['increase_quantity'])) {
            $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param('ii', $_SESSION['user_id'], $product_id);
            $stmt->execute();
        } elseif (isset($_POST['decrease_quantity'])) {
            // Prevent quantity from going below 1
            $check_query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($check_query);
            $stmt->bind_param('ii', $_SESSION['user_id'], $product_id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            if ($result['quantity'] > 1) {
                $update_query = "UPDATE cart SET quantity = quantity - 1 WHERE user_id = ? AND product_id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param('ii', $_SESSION['user_id'], $product_id);
                $stmt->execute();
            }
        }
    } elseif (isset($_POST['remove_product_id'])) {
        $remove_product_id = intval($_POST['remove_product_id']);
        $delete_query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param('ii', $_SESSION['user_id'], $remove_product_id);
        $stmt->execute();
    }
    // Refresh the page to show updated cart
    header("Location: cart.php");
    exit();
}

// Fetch cart items
$cart_query = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$cart_result = $stmt->get_result();

// Calculate total amount
$total_amount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./cat.css">
    <script src="https://kit.fontawesome.com/93a4ced81e.js"></script>
    <title>Your Cart</title>
</head>
<body>
    <!-- Header Section -->
    <section id="header">
        <a href="#"><img src="../../pics/logo.png" class="logo" alt="Logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">HOME</a></li>
                <li><a href="shop.php">SHOP</a></li>
                <li><a href="about.html">ABOUT US</a></li>
                <li><a href="contact.html">CONTACT</a></li>
                <li><a href="cart.php" class="active"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="./userprofile/profile.php"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

    <!-- Cart Section -->
    <!-- Cart Section -->
    <section id="cart">
    <h1>Your Cart</h1>
    <div class="cart-items">
        <?php 
        $has_items = false; // Flag to check if the cart has items
        while ($item = $cart_result->fetch_assoc()) { 
            $item_total = $item['price'] * $item['quantity'];
            $total_amount += $item_total;
            $has_items = true; // Cart has at least one item
        ?>
            <div class="cart-item">
                <img src="../backend/uploads/<?php echo htmlspecialchars($item['image_url']); ?>" alt="Product Image">
                <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                <p>₱ <?php echo number_format($item['price'], 2); ?> x <?php echo $item['quantity']; ?></p>
                <p>Total: ₱ <?php echo number_format($item_total, 2); ?></p>
                <form method="POST" action="cart.php" class="quantity-form">
                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                    <button type="submit" name="decrease_quantity" class="btn">-</button>
                    <span><?php echo $item['quantity']; ?></span>
                    <button type="submit" name="increase_quantity" class="btn">+</button>
                </form>
                <form method="POST" action="cart.php" class="remove-form">
                    <input type="hidden" name="remove_product_id" value="<?php echo $item['product_id']; ?>">
                    <button type="submit" class="btn">Remove</button>
                </form>
            </div>
        <?php } ?>
    </div>
    <div class="cart-total">
        <h3>Total Amount: ₱ <?php echo number_format($total_amount, 2); ?></h3>
    </div>
    <?php if ($has_items) { ?>
        <div class="checkout-button">
            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    <?php } else { ?>
        <p>Your cart is empty. <a href="shop.php">Shop Now</a></p>
    <?php } ?>
</section>

</body>
</html>
