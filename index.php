<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: login.php");
    exit(0);
}

$page_title = "Home Page";
include("includes/header.php");
include("includes/navbar.php");

?>
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Login and Registration System in PHP</h2>
                <h4>With Email Verifcation</h4>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>