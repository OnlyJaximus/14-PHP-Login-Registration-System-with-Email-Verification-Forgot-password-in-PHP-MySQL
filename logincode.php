<?php
session_start();
require_once("dbcon.php");


if (isset($_POST['login_btn'])) {

    if (!empty(trim($_POST['email_address'])) && !empty(trim($_POST['password']))) {


        $email = mysqli_escape_string($con, $_POST['email_address']);
        $password = mysqli_escape_string($con, $_POST['password']);

        // $login_query = "SELECT * FROM users3 WHERE email = '$email' AND password = '$password' LIMIT 1";

        $login_query = "SELECT * FROM users3 WHERE email = '$email' LIMIT 1";

        $login_query_run = mysqli_query($con, $login_query);

        // print_r($login_query_run);
        //  mysqli_result Object ( [current_field] => 0 [field_count] => 8 [lengths] => [num_rows] => 1 [type] => 0 )


        if (mysqli_num_rows($login_query_run) > 0) {
            $row = mysqli_fetch_array($login_query_run);
            // echo $row['verify_status'];  // 1 = verified or 0 no verified

            $password_hash = $row['password'];
            // print_r($password_hash);

            if ($row['verify_status'] == 1) {
                if (password_verify($password, $password_hash)) {
                    $_SESSION['authenticated'] = TRUE;
                    $_SESSION['auth_user'] = [
                        'username' => $row['name'],
                        'phone' => $row['phone'],
                        'email' => $row['email'],
                    ];
                    $_SESSION['status'] = "You are logged In Successfully.";
                    header("Location: dashboard.php");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Invalid Email or Password";
                    header("Location: login.php");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Please, Verify your Email Address to Login.";
                header("Location: login.php");
                exit(0);
            }
        }
    } else {
        $_SESSION['status'] = "All fields are Mandetory";
        header("Location: login.php");
        exit(0);
    }
}



//  Bez hash passworda
// if (isset($_POST['login_btn'])) {

//     if (!empty(trim($_POST['email_address'])) && !empty(trim($_POST['password']))) {


//         $email = mysqli_escape_string($con, $_POST['email_address']);
//         $password = mysqli_escape_string($con, $_POST['password']);




//         $login_query = "SELECT * FROM users3 WHERE email = '$email' AND password = '$password' LIMIT 1";
//         $login_query_run = mysqli_query($con, $login_query);

//         // print_r($login_query_run);
//         //  mysqli_result Object ( [current_field] => 0 [field_count] => 8 [lengths] => [num_rows] => 1 [type] => 0 )


//         if (mysqli_num_rows($login_query_run) > 0) {
//             $row = mysqli_fetch_array($login_query_run);
//             // echo $row['verify_status'];  // 1 = verified or 0 no verified

//             if ($row['verify_status'] == 1) {
//                 $_SESSION['authenticated'] = TRUE;
//                 $_SESSION['auth_user'] = [
//                     'username' => $row['name'],
//                     'phone' => $row['phone'],
//                     'email' => $row['email'],
//                 ];
//                 $_SESSION['status'] = "You are logged In Successfully.";
//                 header("Location: dashboard.php");
//                 exit(0);
//             } else {
//                 $_SESSION['status'] = "Please, Verify your Email Address to Login.";
//                 header("Location: login.php");
//                 exit(0);
//             }
//         } else {
//             $_SESSION['status'] = "Invalid Email or Password";
//             header("Location: login.php");
//             exit(0);
//         }
//     } else {
//         $_SESSION['status'] = "All fields are Mandetory";
//         header("Location: login.php");
//         exit(0);
//     }
// }
