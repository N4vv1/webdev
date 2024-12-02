<?php
include('../db/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE product_id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: http://localhost/WEB%20DEV%20KITCHEN/WEB%20DEV%20KITHCENWARE/code/backend/templates/productList.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
