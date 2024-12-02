<?php
// Include database connection
include('../db/db.php');

// Get the product ID from the URL
$product_id = $_GET['id'];

// Fetch the product data from the database
$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// If the product is not found, redirect or display an error
if (!$product) {
    echo "Product not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    // Handle image upload (if a new image is uploaded)
    if ($_FILES['image']['name']) {
        $targetDir = "../../uploads/";
        $imageFile = $targetDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imageFile)) {
            $imagePath = "../../uploads/" . basename($_FILES['image']['name']);
        } else {
            echo "Error uploading image.";
            exit;
        }
    } else {
        // If no new image is uploaded, keep the old image
        $imagePath = $product['image_url'];
    }

    // Update the product in the database
    $sql = "UPDATE products SET 
            product_name = '$name',
            price = '$price',
            description = '$description',
            category = '$category',
            stock = '$stock',
            image_url = '$imagePath' 
            WHERE product_id = $product_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: http://localhost/WEB%20DEV%20KITCHEN/WEB%20DEV%20KITHCENWARE/code/backend/templates/productList.php"); // Redirect to the product list page
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            width: 50%;
            max-width: 600px;
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <div class="back-button">
        <a href="productList.php" class="btn btn-secondary">Back</a>
    </div>

    <div class="form-container border p-4 shadow">
        <h1 class="text-center">Edit Product</h1>
        <form action="editProduct.php?id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label"><b>Product Name</b></label>
                <input type="text" name="name" class="form-control w-50 mx-auto" value="<?php echo $product['product_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label"><b>Price</b></label>
                <input type="number" step="0.01" name="price" class="form-control w-25 mx-auto" value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label"><b>Description</b></label>
                <textarea name="description" class="form-control w-100 mx-auto" required><?php echo $product['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label"><b>Category</b></label>
                <input type="text" name="category" class="form-control w-50 mx-auto" value="<?php echo $product['category']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label"><b>Stock</b></label>
                <input type="number" name="stock" class="form-control w-25 mx-auto" value="<?php echo $product['stock']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label"><b>Image</b></label>
                <input type="file" name="image" class="form-control w-75 mx-auto">
                <img src="<?php echo $product['image_url']; ?>" alt="Product Image" style="width: 100px; margin-top: 10px;">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary"><b>Save Changes</b></button>
            </div>
        </form>
    </div>
</body>
</html>
