<?php
session_start();
require_once("dbcon.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token)
{

    $mail = new PHPMailer(true);


    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
    $mail->isSMTP();
    $mail->SMTPAuth   = true;

    $mail->Host       = 'smtp.gmail.com';
    $mail->Username   = 'testmercatesting@gmail.com';
    $mail->Password   = 'glcqcslljdltrrph';

    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('testmercatesting@gmail.com', $get_name);
    $mail->addAddress($get_email);



    //Content
    $mail->isHTML(true);  //Set email format to HTML

    $mail->Subject = 'Reset Password Notification from Blex of Web';

    $email_template = "
            <h2>Hello</h2>
            <h3>You are receiving this email becase we received a password reset request for your account.</h3>
            </br></br>
          
            </br></br>
            <a href='http://localhost/fundaOfWebPhpVerfiedLogReg/password-change.php?token=$token&email=$get_email'>Click me</a><br>Regards<br><h3>Blex!</h3>
        ";
    // <a href='http://localhost/fundaOfWebPhpVerfiedLogReg/password-change.php?token=$token&email=$get_email'>
    // http://localhost/fundaOfWebPhpVerfiedLogReg/password-change.php?token=$token&email=$get_email
    // </a>    
    $mail->Body = $email_template;
    $mail->send();
    // echo "Message has benn sent";

}


# Za slanje linka na emila
if (isset($_POST['password_reset_link'])) {

    if (!empty(trim($_POST['email']))) {

        $email = mysqli_real_escape_string($con, $_POST['email']);
        $token = md5(rand());

        $check_email = "SELECT * FROM users3 WHERE email = '$email' LIMIT 1";
        $check_email_run = mysqli_query($con, $check_email);


        if (mysqli_num_rows($check_email_run) > 0) {

            $row =  mysqli_fetch_array($check_email_run);
            $get_name = $row['name'];
            $get_email = $row['email'];

            $update_token = "UPDATE users3 SET verify_token = '$token' WHERE email = '$get_email' LIMIT 1";
            $update_token_run = mysqli_query($con, $update_token);

            if ($update_token_run) {
                send_password_reset($get_name, $get_email, $token);
                $_SESSION['status'] = "We e-mailed you a password reset link!";
                header("Location: password-reset.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Something went wrong #1!";
                header("Location: password-reset.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "No email address found!";
            header("Location: password-reset.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Please, enter the email field!!";
        header("Location: password-reset.php");
        exit(0);
    }
}



# RESET PASSWORD
# Nakon sto smo kliknuli na link sa email, vodi nas na formu gde se dalji kod odvija ovde.
if (isset($_POST['password_update'])) {

    $email = mysqli_real_escape_string($con, $_POST['email_address']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    $token = mysqli_real_escape_string($con, $_POST['password_token']);

    if (!empty($token)) {

        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {

            // Checking toklen is valid or not
            $check_token = "SELECT verify_token FROM users3 WHERE verify_token = '$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                if ($new_password == $confirm_password) {

                    $hash_password = password_hash($new_password, PASSWORD_DEFAULT);
                    // $update_password = "UPDATE users3 SET password = '$new_password' WHERE  verify_token = '$token' LIMIT 1";
                    $update_password = "UPDATE users3 SET password = '$hash_password' WHERE  verify_token = '$token' LIMIT 1";
                    $update_password_rum = mysqli_query($con, $update_password);

                    if ($update_password_rum) {

                        # Da bi sprecili da se preko linka ne emailu moze resetovati password
                        # postavljamo novi token

                        $new_token = md5(rand()) . "blex";
                        $update_new_token = "UPDATE users3 SET  verify_token = '$new_token' WHERE  verify_token = '$token' LIMIT 1";
                        $update_new_token_rum = mysqli_query($con,  $update_new_token);

                        $_SESSION['status'] = "New Password Successfully Updated!";
                        header("Location:login.php");
                        exit(0);
                    } else {
                        $_SESSION['status'] = "Did not update password. Something went wronmg!";
                        header("Location: password-change.php");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "Password and Confirm Password does not match";
                    header("Location: password-change.php");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Invalid Token!";
                header("Location: password-change.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "All Field are Manetory";
            header("Location: password-change.php?token=$token&email=$email");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No Token Available";
        header("Location: password-change.php");
        exit(0);
    }
}
