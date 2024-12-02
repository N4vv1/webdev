<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K Depot - Login</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/93a4ced81e.js"></script>
    <link rel="icon" href="../pics/logo.png" type="image/gif" sizes="16x16">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <section id="header">
        <a href="#"><img src="../../../pics/logo.png" class="logo" alt="K Depot Logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="../view_only/homepage.html">HOME</a></li>
                <li><a href="login.php">SHOP</a></li>
                <li><a href="../view_only/about.html">ABOUT US</a></li>
                <li><a href="../view_only/contact.html">CONTACT</a></li>
                <li><a href="login.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="login.php" class="active"><i class="fa-solid fa-user"></i></a></li>
            </ul>
        </div>
    </section>

    <section class="login">
        <div class="wrapper">
            <form action="./loginApi.php" method="POST">
                <h1>Login</h1>
                <?php if (isset($error)): ?>
                    <p style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="remember-forgot">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="#"><span>Forgot password?</span></a>
                </div>

                <button type="submit" class="btn">Login</button>

                <div class="register-link">
                    <p>Don't have an account? <a href="register.php"><span>Register</span></a></p>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
