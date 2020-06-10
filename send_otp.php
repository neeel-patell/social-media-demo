<?php
    require 'mail/mail_sender.php';
    require 'connection.php';
    session_start();
    $conn = getConn();
    
    $email = $_POST['email'];
    $query = "select id from user where email='$email'"; // fetched ID available for check email exist or not
    $result = $conn->query($query);
    if(mysqli_num_rows($result) == 0){
        $_SESSION['email'] = $email;
        $otp = rand(100000,999999); // random otp generated
        $_SESSION['otp'] = $otp; // otp session set
        $_SESSION['otptime'] = new DateTime(date("Y-m-d H:i:s")); // current time set to compare time 
        $body = "The One time password for verification is <font color='blue' size='2'><u>$otp</u></font> which is valid for 30 Minutes.";
        sendMail($email,"One Time Password for Verification",$body); // mail send with otp generated
        header("location: registration.php?msg=eo");
    }
    else{ // email already exist
        header("location: registration.php?msg=ee");
    }

?>