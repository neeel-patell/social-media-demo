<?php
    session_start();
    $otp = $_POST['otp'];
    $otpsent = $_SESSION['otp'];
    $otptime = $_SESSION['otptime'];
    $time = new DateTime(date("Y-m-d H:i:s"));
    $diff = $otptime->diff($time);
    $min = $diff->i;
    if(isset($_SESSION['counter'])){
        $counter = $_SESSION['counter'] ;
        $counter++;
    }
    else{
        $counter = 1;
    }
    $_SESSION['counter'] = $counter;
    if($otp == $otpsent && $min <= 30 && $min >= 0 && $counter < 5){
        $_SESSION['otpfail'] = 0;
        unset($_SESSION['otp']);
        unset($_SESSION['otptime']);
        header("location: registration.php");
    }
    else{
        if($min > 30 || $min < 0){
            header("location: registration.php?msg=te");
        }
        else if($counter >= 5){
            header("location: registration.php?msg=mt");
        }
        else{
            header("location: registration.php?msg=nm");
        }
    }
?>