<?php
// start output buffering
ob_start();

// start session
session_start();

// regenerate session id
session_regenerate_id();

// unset all data session
unset($_SESSION['website']);
// session_unset();
// session_destroy();
// redirect to the login page
header('Location: ./login.php');

// output flush
ob_end_flush();

// exit
exit();
