
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K Depot - User Profile</title>
    <link rel="stylesheet" href="./profile.css">
    <script src="https://kit.fontawesome.com/93a4ced81e.js"></script>
    <link rel="icon" href="../pics/logo.png" type="image/gif" sizes="16x16">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

  <section id="header">
    <a href="#"><img src="../pics/logo.png" class="logo"></a>
    <div>
        <ul id="navbar">
            <li><a href="../index.php">HOME</a></li>
            <li><a href="../shop.php">SHOP</a></li>
            <li><a href="../about.html">ABOUT US</a></li>
            <li><a href="../contact.html">CONTACT</a></li>
            <li><a href="../cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <li><a href="profile.php" class="active"><i class="fa-solid fa-user"></i></a></li>
        </ul>
    </div>
</section>

  <div class="dashboard">
    <h1>User Profile</h1>
    <form id="userForm">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" placeholder="Enter your name">

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email">

      <label for="contact">Contact Number:</label>
      <input type="tel" id="contact" name="contact" placeholder="Enter your contact number">

      <label for="address">Address:</label>
      <textarea id="address" name="address" placeholder="Enter your address" rows="3"></textarea>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter your password">

      <button type="button" id="saveBtn">Save Changes</button>
      
    </form>
    
    <!-- Sign Out button form -->
    <form action="logout.php" method="POST" style="display: inline;">
        <button type="submit" id="signOutBtn">Sign Out</button>
      </form>
  </div>

  <script>
    // Optional: you can add a confirmation alert before sign out if needed
    document.getElementById('signOutBtn').addEventListener('click', function(event) {
      if (!confirm("Are you sure you want to sign out?")) {
        event.preventDefault(); // Prevent form submission if user cancels
      }
    });
  </script>
  
</body>
</html>
