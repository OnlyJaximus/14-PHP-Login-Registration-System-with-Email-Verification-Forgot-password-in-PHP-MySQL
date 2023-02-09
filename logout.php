<?php

session_start();
// session_destroy();

unset($_SESSION['authenticated']);
unset($_SESSION['auth_user']);
$_SESSION['status'] = "You Logged Out Successfully!";
header("Location: login.php");
