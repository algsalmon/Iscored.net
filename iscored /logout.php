<?php
ob_start();
session_start();

// Unset all of the session variables.
session_unset();
// Finally, destroy the session.
session_destroy();

header("Location: index.php");

ob_end_flush();

?>
