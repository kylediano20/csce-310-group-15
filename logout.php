<?php
// file coded by Kyle Diano
session_start();

// Clear session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: index.html");
exit;
?>
