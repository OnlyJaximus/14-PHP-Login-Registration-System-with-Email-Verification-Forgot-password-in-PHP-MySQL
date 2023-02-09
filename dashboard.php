<?php
require_once("logincode.php");
if (!isset($_SESSION['authenticated'])) {
    header("Location: login.php");
    exit(0);
}

$page_title = "Dashboard";
include("includes/header.php");
include("includes/navbar.php");

// require_once("logincode.php");

?>
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_SESSION['status'])) {
                ?>
                    <div class="alert alert-success">
                        <h5><?php echo $_SESSION['status']; ?></h5>
                    </div>
                <?php
                    unset($_SESSION['status']);
                }
                ?>


                <div class="card">

                    <div class="card-header">
                        <h4>User Dashboard</h4>
                    </div>

                    <div class="card-body">
                        <h2>Access when you are logged IN!</h2>
                        <hr>
                        <h5>Username: <?php echo $_SESSION['auth_user']['username']; ?></h5>
                        <h5>Email Address: <?php echo $_SESSION['auth_user']['email']; ?></h5>
                        <h5>Phone No: <?php echo $_SESSION['auth_user']['phone']; ?></h5>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>