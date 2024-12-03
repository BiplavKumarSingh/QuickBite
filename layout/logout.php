<?php
// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the homepage (or login page)
header("Location: ./index.php"); // Or redirect to login page: header("Location: ./login.php");
exit(); // Ensures the script stops after the redirection
?>