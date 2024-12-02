<?php
// Start the session at the beginning of the file
session_start();

// Check if the form is submitted and the email field exists in the POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $_SESSION['email'] = $_POST['email'];  // Store the email in the session
    // Optionally, you can redirect to the next page if email is set
    header("Location: register2.php");  // Redirect to the next step after storing the email
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K Depot - Register</title>
    <link rel="stylesheet" href="./register.css">
    <script src="https://kit.fontawesome.com/93a4ced81e.js"></script>
    <link rel="icon" href="../../../pics/logo.png type="image/gif" sizes="16x16">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <section id="header">
        <a href="#"><img src="../../backend../pics/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="../view_only/homepage.html">HOME</a></li>
                <li><a href="../view_only/shop.html">SHOP</a></li>
                <li><a href="../view_only/about.html">ABOUT US</a></li>
                <li><a href="../view_only/contact.html">CONTACT</a></li>
                <li><a href="../view_only/cart  .html"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="login.php"  class="active"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

    <section class="register">
        <div class="wrapper">
            <form action="register2.php" method="POST">
                <h1>Create Account</h1>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email Address" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="login-link">
                    <p>Already have an account? <a href="login.php"><span>Login</span></a></p>
                </div>
            </form>
        </div>
    </section>

</body>
</html>
