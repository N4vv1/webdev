<?php
session_start();
include('../backend/db/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login/login.php");
    exit();
}

// Check if the payment method is selected
if (isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'];

    // Save the payment method to session
    $_SESSION['payment_method'] = $payment_method;

    // Redirect to the confirmation page
    header("Location: order_confirmation.php");
    exit();
} else {
    echo "No payment method selected.";
}
