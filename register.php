<?php
session_start();


if (isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "You are already Registered User!";
    header("Location: dashboard.php");
    exit(0);
}



$page_title = "Registration Form";
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
                        <h5>Registration Form with Email Verification</h5>
                    </div>

                    <div class="card-body">
                        <form action="code.php" method="POST">

                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email_address">Email Address</label>
                                <input type="email" name="email_address" id="email_address" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password mb-3" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <button type="sub" class="btn btn-primary" name="register_btn">Register Now</button>
                            </div>



                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>