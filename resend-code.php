<?php
session_start();
require_once "dbcon.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function resend_email_verify($name, $email, $verify_token)
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
    $mail->setFrom('testmercatesting@gmail.com', $name);
    $mail->addAddress($email);



    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Resend - Email Verification from Blex of Web';

    $email_template = "
            <h2>You have Registered with Blex of Web</h2>
            <h5>Verify your email address to Login with the below given link</h5>
            </br></br>
            <a href='http://localhost/fundaOfWebPhpVerfiedLogReg/verify-email.php?token=$verify_token'>Click me</a>
        ";
    $mail->Body = $email_template;
    $mail->send();
    // echo "Message has benn sent";

}


if (isset($_POST['resend_email_verify_btn'])) {

    if (!empty(trim($_POST['email']))) {
        $email = mysqli_real_escape_string($con, $_POST['email']);

        $check_email_query = "SELECT * FROM users3 WHERE email = '$email' LIMIT 1";
        $check_email_query_run = mysqli_query($con, $check_email_query);

        if (mysqli_num_rows($check_email_query_run) > 0) {

            $row = mysqli_fetch_array($check_email_query_run);

            if ($row['verify_status'] == "0") {

                $name = $row['name'];
                $email = $row['email'];
                $token = $row['verify_token'];

                //  Test
                // echo $token;  // 65eb966076c5d7eed2ba7348e6b8f420

                resend_email_verify($name, $email, $token);

                $_SESSION['status'] = "Verification Email Link has been sent to your email address!";
                header("Location: login.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Email address is already verifeid. Please, Login!";
                header("Location: resend-email-verification.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Email is not registerd. Please, register now!";
            header("Location: register.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Please, enter the email field!";
        header("Location: resend-email-verification.php");
        exit(0);
    }
}
