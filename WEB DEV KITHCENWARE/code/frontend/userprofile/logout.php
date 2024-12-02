<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page
header("Location: http://localhost/WEB%20DEV%20KITCHEN/WEB%20DEV%20KITHCENWARE/code/frontend/view_only/homepage.html");
exit();
?>
