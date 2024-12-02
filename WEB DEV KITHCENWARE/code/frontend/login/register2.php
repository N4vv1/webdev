<?php
// Start the session
session_start();

// Capture the email input from the form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['email'] = $_POST['email'];  // Store the email in the session
    // Debugging: See session content after setting the session variable
    var_dump($_SESSION);
    header("Location: register2.php");  // Redirect to the next page after storing the email
    exit;
}

$email = isset($_SESSION['email']) ? $_SESSION['email'] : ''; // Ensure there's a fallback if no email is set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K Depot - Register</title>
    <link rel="stylesheet" href="./register.css">
    <script src="https://kit.fontawesome.com/93a4ced81e.js"></script>
    <link rel="icon" href="../../../pics/logo.png" type="image/gif" sizes="16x16">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <section id="header">
        <a href="#"><img src="../../../pics/logo.png" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="../view_only/index.html">HOME</a></li>
                <li><a href="../view_only/shop.php">SHOP</a></li>
                <li><a href="../view_only/about.html">ABOUT US</a></li>
                <li><a href="../view_only/contact.html">CONTACT</a></li>
                <li><a href="../view_only/cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="login.php" class="active"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

    <section class="register">
        <div class="wrapper">
            <form action="verify.php" method="POST">
                <h1>Register</h1>
                <div class="input-box">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="middle_name" placeholder="Middle Name" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="last_name" placeholder="Last Name" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required readonly>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="contact_number" placeholder="Contact Number" required>
                    <i class='bx bxs-phone'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="address" placeholder="Address" required>
                    <i class='bx bxs-map'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <i class='bx bxs-lock'></i>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="login-link">
                    <p>Already have an account? <a href="login.html"><span>Login</span></a></p>
                </div>
            </form>
            <button class="back-btn" onclick="window.location.href='register.php'">Back</button>
        </div>
    </section>
</body>
</html>
