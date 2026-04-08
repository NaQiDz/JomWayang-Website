<?php
// Destroy all session data
session_start();
session_destroy();
$_SESSION['userid'] = 0;
// Redirect to the login page or home page
header("Location: ../index.php");
?>
