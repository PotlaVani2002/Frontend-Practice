<?php
require 'config/constants.php';
session_start(); // Start the session before destroying it

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect the user to the home page
header('Location: ' . ROOT_URL);
exit(); // Use exit instead of die() for a more common approach
?>
