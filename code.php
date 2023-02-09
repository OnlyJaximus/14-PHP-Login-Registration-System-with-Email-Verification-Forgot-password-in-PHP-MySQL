<?php
session_start();
include("dbcon.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);


    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->Username   = 'testmercatesting@gmail.com';                     //SMTP username
    $mail->Password   = 'glcqcslljdltrrph';                               //SMTP password

    $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('testmercatesting@gmail.com', $name);
    $mail->addAddress($email);     //Add a recipient



    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email Verification from Blex of Web';

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





if (isset($_POST['register_btn'])) {

    // $name = $_POST['name'];
    // $phone_number = $_POST['phone_number'];
    // $email_address = $_POST['email_address'];
    // $password   = $_POST['password'];
    // $confirm_password = $_POST['confirm_password'];

    $name =  mysqli_real_escape_string($con, $_POST['name']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $email_address = mysqli_real_escape_string($con, $_POST['email_address']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password =  mysqli_real_escape_string($con, $_POST['confirm_password']);
    $verify_token = md5(rand());

    $hash_password = password_hash($password, PASSWORD_DEFAULT);


    // Just for test
    // sendemail_verify("$name", "$email_address", "$verify_token");
    // echo "Sent or not?";


    // Email Exists or not

    # 1
    $check_email_query = "SELECT email FROM users3 WHERE email ='$email_address' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);


    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['status'] = "Email address already Exists";
        header("Location: register.php");
    } else {

        if ($password  == $confirm_password) {
            // Insert User/ Registered Data
            $query =  "INSERT INTO users3 (name, phone, email, password, verify_token) 
   VALUES ('$name', '$phone_number', '$email_address', '$hash_password', '$verify_token')";
            $query_run = mysqli_query($con, $query);

            if ($query_run) {
                sendemail_verify("$name", "$email_address", "$verify_token");
                $_SESSION['status'] = "Registration Successfull! Please, verify your Email Address.";
                header("Location: register.php");
            } else {
                $_SESSION['status'] = "Registration failed";
                header("Location: register.php");
            }
        } else {
            $_SESSION['status'] = "Password and Confirm Password does not match";
            header("Location: register.php");
            exit(0);
        }
    }
}
