<?php
include '../System/sessionHandler.php';
session_start();

adminSystem::endUserSession();

// Redirect the user to the login page
header('Location: login.php');
exit();
?>
