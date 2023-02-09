<?php
session_start();
if (isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "You are already Logged In!";
    header("Location: dashboard.php");
    exit(0);
}


$page_title = "Login Form";
include("includes/header.php");
include("includes/navbar.php");

?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
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

                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login Form</h5>
                    </div>

                    <div class="card-body">
                        <form action="logincode.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="email_address">Email Address</label>
                                <input type="text" name="email_address" id="email_address" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>


                            <div class="form-group mb-3">
                                <button type="sub" class="btn btn-primary" name="login_btn">Login Now</button>
                                <a href="password-reset.php" class="float-end">Forgot Your Password?</a>
                            </div>

                            <hr>
                            Did not recive your Verification Email?
                            <a href="resend-email-verification.php">Resend</a>



                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>