<?php

session_start();
$_SESSION = array();

// Unset all of the session variables
$_SESSION["loggedin"] = false;
unset($_SESSION['loggedin']);

// Destroy the session.
session_destroy();

// Redirect to home page
header("Location: index.php?page=home");

exit;
?>