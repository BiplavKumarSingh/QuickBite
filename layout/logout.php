<?php
// Start the session
session_start();

// Unset all session data
session_unset();

// Destroy the session
session_destroy();


// Redirect to index.php (outside the layout folder)
header("Location: ./index.php"); // Navigate up one directory level
exit(); // Stop the script here to prevent further execution
?>
