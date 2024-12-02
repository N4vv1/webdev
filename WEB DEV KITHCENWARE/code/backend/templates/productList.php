<?php include('../db/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Inventory Management</title>
</head>
<body>

    <!-- Back Button to Admin Dashboard and Add Product Button -->
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <!-- Back to Dashboard Button -->
            <a href="../db/admin.php" class="btn btn-secondary">Back</a>
            
            <!-- Add Product Button -->
            <a href="addProduct.php" class="btn btn-success">Add Product</a>
        </div>
    </div>

    <!-- Inventory Management Table -->
    <div class="container mt-4">
        <h1>Inventory Management</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to get the list of products
                $result = $conn->query("SELECT * FROM products");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>
                                <img src='" . htmlspecialchars($row['image_url']) . "' alt='Product Image' style='width: 50px; height: 50px; object-fit: cover;'>
                            </td>
                            <td>{$row['product_id']}</td>
                            <td>{$row['product_name']}</td>
                            <td>₱ {$row['price']}</td>
                            <td>{$row['stock']}</td>
                            <td>
                                <button class='btn btn-sm btn-info view-btn' data-id='{$row['product_id']}'>View</button>
                                <a href='editProduct.php?id={$row['product_id']}' class='btn btn-sm btn-warning'>Edit</a>
                                <a href='deleteProduct.php?id={$row['product_id']}' class='btn btn-sm btn-danger'>Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Product Details Modal -->
    <div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProductModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="productDetails">
                        <!-- Product details will be dynamically populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // jQuery to load product details into the modal when the "View" button is clicked
        $(document).ready(function() {
            $('.view-btn').on('click', function() {
                var productId = $(this).data('id'); // Get the product ID
                $.ajax({
                    url: 'getProductDetails.php', // Send a request to this file to fetch product details
                    type: 'GET',
                    data: { id: productId },
                    success: function(response) {
                        // Populate the modal with product details
                        $('#productDetails').html(response);
                        $('#viewProductModal').modal('show');
                    },
                    error: function() {
                        alert('Error retrieving product details.');
                    }
                });
            });
        });
    </script>
</body>
</html>
