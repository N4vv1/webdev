<?php
session_start();
require '../../backend/db/db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // Password submitted by the user

    // Query to check user credentials
    $sql = "SELECT * FROM user_info WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Debugging: output the user details fetched from the database
        // var_dump($user); // Uncomment for debugging

        // Verify the password with the hashed password stored in the database
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['role'] = $user['role']; // Store the role in the session

            // Redirect based on the user's role
            if ($_SESSION['role'] === 'admin') {
                // Redirect to admin dashboard if the user is an admin
                header("Location: http://localhost/WEB%20DEV%20KITCHEN/WEB%20DEV%20KITHCENWARE/code/backend/db/admin.php");
                exit();
            } else {
                // Redirect to the default page for regular users (e.g., homepage)
                header("Location: http://localhost/WEB%20DEV%20KITCHEN/WEB%20DEV%20KITHCENWARE/code/frontend/index.php");
                exit();
            }
        } else {
            $error = "Invalid password.";
            // Debugging: Log error when password is incorrect
            error_log("Login failed for email: $email. Invalid password.");
        }
    } else {
        $error = "User not found.";
        // Debugging: Log error when user is not found
        error_log("Login failed. No user found with email: $email.");
    }

    $stmt->close();
    $conn->close();
}
?>
