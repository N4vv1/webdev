<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Add Product</title>
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
        <h1 class="text-center">Add New Product</h1>
        <form action="addProduct.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label"><b>Product Name</b></label>
                <input type="text" name="name" class="form-control w-50 mx-auto" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label"><b>Price</b></label>
                <input type="number" step="0.01" name="price" class="form-control w-25 mx-auto" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label"><b>Description</b></label>
                <textarea name="description" class="form-control w-100 mx-auto" required></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label"><b>Category</b></label>
                <input type="text" name="category" class="form-control w-50 mx-auto" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label"><b>Stock</b></label>
                <input type="number" name="stock" class="form-control w-25 mx-auto" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label"><b>Image</b></label>
                <input type="file" name="image" class="form-control w-75 mx-auto" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary"><b>Add Product</b></button>
            </div>
        </form>
    </div>

    <?php
    include('../db/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $stock = $_POST['stock'];

        // Handle image upload
        $targetDir = "../uploads/";
        $imageFile = $targetDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imageFile)) {
            $imagePath = "../uploads/" . basename($_FILES['image']['name']);
        } else {
            echo "Error uploading image.";
            exit;
        }

        // Insert product data into the database
        $sql = "INSERT INTO products (product_name, price, description, category, stock, image_url) 
                VALUES ('$name', '$price', '$description', '$category', '$stock', '$imagePath')";

        if ($conn->query($sql) === TRUE) {
            header("Location: http://localhost/WEB%20DEV%20KITCHEN/WEB%20DEV%20KITHCENWARE/code/backend/templates/productList.php"); // Redirect to the product display page
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>

</body>
</html>
