<?php



session_start();
session_unset();
session_destroy();

// Set a session message for logout success
session_start();
$_SESSION['success_message'] = "You have logged out successfully.";

header("Location: /login.php");
exit();


?>

