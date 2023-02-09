<?php
session_start();

$page_title = "Password Change Update";
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
                        <h5>Change Password</h5>
                    </div>

                    <div class="card-body">

                        <form action="password-reset-code.php" method="POST">

                            <!-- Hidden INPUT za token  -->
                            <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                                                                                    echo $_GET['token'];
                                                                                } ?>">


                            <div class=" form-group mb-3">
                                <label for="email_address">Email Address</label>
                                <input type="text" name="email_address" value="<?php if (isset($_GET['email'])) {
                                                                                    echo $_GET['email'];
                                                                                } ?>" id="email_address" class="form-control" placeholder="Enter Email Adddress">
                            </div>

                            <div class="form-group mb-3">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter New Password">
                            </div>

                            <div class="form-group mb-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter Confirm Password">
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" name="password_update" class="btn btn-success w-100">Update Password</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>