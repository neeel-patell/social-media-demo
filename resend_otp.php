<?php
    require 'mail/mail_sender.php';
    session_start();
    unset($_SESSION['counter']);
    
    $otp = rand(100000,999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otptime'] = new DateTime(date("Y-m-d H:i:s"));
    $email = $_SESSION['email'];

    $body = "The One time password for verification is <font color='blue' size='2'><u>$otp</u></font> which is valid for 30 Minutes.";

    sendMail($email,"One Time Password for Verification",$body);

    header("location: registration.php?msg=os");

?>