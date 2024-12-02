<?php
include('../backend/db/db.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/WEB%20DEV%20KITCHEN/WEB%20DEV%20KITHCENWARE/code/frontend/login/login.php");
    exit();
}

// Handle adding products to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    $product_query = "SELECT product_name, price FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    if ($product_result && $product_result->num_rows > 0) {
        $product = $product_result->fetch_assoc();
        $product_name = $conn->real_escape_string($product['product_name']);
        $price = $product['price'];

        // Insert or update the product in the cart
        $cart_query = "INSERT INTO cart (user_id, product_id, product_name, price, quantity) 
                       VALUES (?, ?, ?, ?, ?)
                       ON DUPLICATE KEY UPDATE quantity = quantity + ?";
        $cart_stmt = $conn->prepare($cart_query);
        $cart_stmt->bind_param('iisdis', $user_id, $product_id, $product_name, $price, $quantity, $quantity);
        $cart_stmt->execute();
    }
}   

// Handle Buy Now action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_now_id'])) {
    $buy_now_id = intval($_POST['buy_now_id']);
    header("Location: checkout.php?product_id=$buy_now_id");
    exit();
}

// Filter products by category
$category_filter = "";
$search_filter = "";

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = $conn->real_escape_string($_GET['category']);
    $category_filter = "WHERE category = '$category'";
}

// Search by product name
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $search_filter = "AND product_name LIKE '%$search%'";
}

// Combine filters in the query
$sql = "SELECT * FROM products $category_filter $search_filter";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K Depot</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="shop.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/93a4ced81e.js"></script>
    <link rel="icon" href="../../pics/logo.png" type="image/gif" sizes="16x16">
</head> 
<body>
    <section id="header">
        <a href="#"><img src="../../pics/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">HOME</a></li>
                <li><a href="shop.php" class="active">SHOP</a></li>
                <li><a href="about.html">ABOUT US</a></li>
                <li><a href="contact.html">CONTACT</a></li>
                <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="./userprofile/profile.php"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

    <section id="bg">
        <div>
            <img src="../../pics/bg.png">
            <h1>Shop Now</h1>
        </div>
    </section>

    <!-- Filter and Search Section -->
    <section class="filter">
        <form method="GET" action="shop.php" class="d-flex">
            <label for="category" class="me-2">Filter by Category:</label>
            <select name="category" id="category" class="form-select me-2">
                <option value="">All Categories</option>
                <option value="Cutting Tools" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Cutting Tools') ? 'selected' : ''; ?>>Cutting Tools</option>
                <option value="Cookware" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Cookware') ? 'selected' : ''; ?>>Cookware</option>
                <option value="Utensils" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Utensils') ? 'selected' : ''; ?>>Utensils</option>
                <option value="Tableware" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Tableware') ? 'selected' : ''; ?>>Tableware</option>
                <option value="Kitchen Apparel" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Kitchen Apparel') ? 'selected' : ''; ?>>Kitchen Apparel</option>
                <option value="Kitchen Accessories" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Kitchen Accessories') ? 'selected' : ''; ?>>Kitchen Accessories</option>
            </select>

            <label for="search" class="me-2">Search by Name:</label>
            <input type="text" name="search" id="search" class="form-control me-2" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" placeholder="Search products">
            
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>
    </section>

    <section class="product" id="product">
        <h2>KITCHEN EQUIPMENTS</h2>
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <div class='col'>
                            <div class='card product-card'>
                                <img src='../backend/uploads/{$row['image_url']}' class='card-img-top' alt='Product Image'>
                                <div class='card-body'>
                                    <h5 class='card-title'>{$row['product_name']}</h5>
                                    <p class='card-text'>{$row['description']}</p>
                                    <div class='product-price'>₱ " . number_format($row['price'], 2) . "</div>
                                    <form method='POST' action='shop.php' class='d-inline-block'>
                                        <input type='hidden' name='product_id' value='{$row['product_id']}'>
                                        <button type='submit' class='btn btn-dark w-100 mt-2'>Add to Cart</button> <!-- Dark button -->
                                    </form>
                                    <form method='POST' action='shop.php' class='d-inline-block'>
                                        <input type='hidden' name='buy_now_id' value='{$row['product_id']}'>
                                        <button type='submit' class='btn btn-warning w-100 mt-2'>Buy Now</button> <!-- Warning button -->
                                    </form>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p class='text-center'>No products found.</p>";
                }
                ?>
            </div>
        </div>
    </section>
</body>
</html>
