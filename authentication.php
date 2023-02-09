<?php
session_start();

//    $_SESSION['authenticated'] = TRUE;  // logincode.php line 20

if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please, login to Access User Dashboard!";
    header("Location: login.php");
    exit(0);
}
