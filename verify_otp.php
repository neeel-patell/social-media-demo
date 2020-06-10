<?php
    session_start();
    $otp = $_POST['otp']; // fetched otp user writes
    $otpsent = $_SESSION['otp']; // fetched otp sent to user
    $otptime = $_SESSION['otptime']; // fetched otp time when otp was sent
    $time = new DateTime(date("Y-m-d H:i:s")); // set current time
    $diff = $otptime->diff($time); // find difference of time between otp sent and current time
    $min = $diff->i; // fetched gap of minutes
    if(isset($_SESSION['counter'])){
        $counter = $_SESSION['counter'] ; // no of attempts
        $counter++;
    }
    else{
        $counter = 1;
    }
    $_SESSION['counter'] = $counter;
    if($otp == $otpsent && $min <= 30 && $min >= 0 && $counter < 5){ // check for valid otp
        $_SESSION['otpfail'] = 0; // set otp is varified
        unset($_SESSION['otp']); // deregister otp session
        unset($_SESSION['otptime']); // deregister otptime
        header("location: registration.php");
    }
    else{
        if($min > 30 || $min < 0){ // otp expire
            header("location: registration.php?msg=te");
        }
        else if($counter >= 5){ // no of attempts excided
            header("location: registration.php?msg=mt");
        }
        else{ // otp has not match
            header("location: registration.php?msg=nm");
        }
    }
?>