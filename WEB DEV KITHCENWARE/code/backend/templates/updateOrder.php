<?php
include('../db/db.php');

// Get the order ID and new status from the URL parameters
$orderId = $_GET['cart_id']; // make sure it's cart_id or change according to your link
$newStatus = $_GET['status'];

// Prepare the SQL update query
$sql = "UPDATE cart SET status = ? WHERE cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newStatus, $orderId);
$stmt->execute();

// Redirect back to the order list page
header("Location: orderList.php");
exit();
?>
