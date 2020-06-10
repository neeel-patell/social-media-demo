<?php
    session_start();
    $email = $otp = $msg = "";
    $otpfail = 1; 
    if(isset($_SESSION['email'])){ // email session on which otp sent or varified
        $email = $_SESSION['email'];
    }
    if(isset($_SESSION['otpfail'])){ // will be 0 after email got varified
        $otpfail = $_SESSION['otpfail'];
    }
    if(isset($_SESSION['otp'])){ // random generated otp 
        $otp = $_SESSION['otp'];
    }
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'css_files.php'; ?>
        <title>Social Media Demo - Registration</title>
    </head>
    <body>
        <header class="jumbotron p-5 mdb-color darken-3 mb-0">
            <h4 class="font-weight-bolder text-monospace text-warning"><i class="fas fa-globe"></i> Social App <i class="fas fa-users"></i></h4>
        </header>
        <div class="container-fluid purple-gradient p-3">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 card p-4 mt-5 mb-5">
                    <h3 class="text-center text-monospace p-3">Registration <hr class="bg-warning"></h3>
                    
                    <?php if($msg === 'mt'){ ?>
                    <div class="alert alert-secondary text-center" role="alert">Please try Reset option, maximum try for current OTP has been finished...</div>
                    <?php }else if($msg === 'nm'){ ?>
                    <div class="alert alert-danger text-center" role="alert">One Time Password has not matched with which has sent on your Email...</div>
                    <?php }else if($msg === 'da'){ ?>
                    <div class="alert alert-danger text-center" role="alert">Please Register again Something went wrong...</div>
                    <?php }else if($msg === 'eo'){ ?>
                    <div class="alert alert-primary text-center" role="alert">Please Enter One time Password...</div>
                    <?php } else if($msg === 'os'){ ?>
                    <div class="alert alert-success text-center" role="alert">OTP resent to your Email...</div>
                    <?php } else if($msg === 'ee'){ ?>
                    <div class="alert alert-danger text-center" role="alert">Email or Mobile Already Exist...</div>
                    <?php } else if($msg === 'te'){ ?>
                    <div class="alert alert-danger text-center" role="alert">OTP has been expired...</div>
                    <?php } ?>
                    
                    <?php if($otpfail == 1){ ?> <!-- Visible till OTP got varified -->
                    <form method="post" action="send_otp.php">
                        <div class="form-group p-2">
                            <label class="label">What is your Email? <span class="text-danger">*</span></label>
                            <div class="clearfix">
                                <input type="email" class="form-control w-75 float-left" placeholder="Enter Email" maxlength="256" name="email" id="email" <?php if($email != "") echo 'value="'.$email.'" disabled' ?> autofocus required>
                                <div class="w-25 float-right"><button type="submit" <?php if($email != "") echo 'disabled' ?> class="form-control btn-dark">Get OTP</button></div>
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                    
                    <?php if($otp != "" && $msg != 'mt'){ ?> <!-- Will be visible once OTP has been sent and Will disappear when you enter wrong OTP and expired OTP more than 4 times or OTP got varified -->
                    <form method="post" action="verify_otp.php">
                        <div class="form-group p-2">
                            <label class="label">OTP : </label>
                            <div class="clearfix">
                                <input type="text" class="form-control w-50 float-left" placeholder="Enter OTP" maxlength="6" minlength="6" name="otp" id="otp" autofocus required>
                                <div class="w-25 float-right"><button type="submit" class="form-control btn-warning brown-text">Verify OTP</button></div>
                                <a onclick='location.href="resend_otp.php"' class="btn p-1 btn-link text-primary">Resend OTP</a>
                            </div>
                        </div>
                    </form>
                    <?php } ?>

                    <?php if($otpfail == 0){ ?> <!-- Will be visible once OTP has been verified -->
                    <form method="post" action="register_user.php" onsubmit="return check()">
                        <div class="form-group p-2">
                            <label class="label">What is your Email? <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" <?php if($email != "") echo 'value="'.$email.'" disabled'; ?>>
                        </div>
                        <div class="form-group p-2">
                            <label class="label">What is your First Name? <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Your First Name" maxlength="30" name="first_name" id="first_name" autofocus required>
                        </div>
                        <div class="form-group p-2">
                            <label class="label">What is your Last Name? <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Your Last Name" maxlength="30" name="last_name" id="last_name" required>
                        </div>
                        <div class="form-group p-2">
                            <label class="label">What is your Mobile Number? <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Your Mobile Number" maxlength="10" minlength="10" name="mobile" id="mobile" required>
                        </div>
                        <div class="form-group p-2">
                            <label class="label">What is your Date of Birth? (DD/MM/YYYY) <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" placeholder="Enter Your Birthday" name="dob" id="dob" required>
                        </div>
                        <div class="form-group p-2">
                            <label class="label">Password: <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Password" name="password" id="pass" minlength="8" maxlength="32" id="password" required>
                            <label class="ml-4 mt-1 form-check-label"><input type="checkbox" tabindex="-1" name="chkpass" id="chkpass" onchange='showPass("chkpass","pass")' class="form-check-input">Show Password</label>
                        </div>
                        <div class="form-group p-2">
                            <label class="label">Confirm Password:  <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirmpass" id="confirmpass" minlength="8" maxlength="32" required>
                            <label class="ml-4 mt-1 form-check-label"><input type="checkbox" tabindex="-1" id="chkconfirmpass" name="chkconfirmpass" onchange='showPass("chkconfirmpass","confirmpass")' class="form-check-input">Show Password</label>
                        </div>
                        <div class="form-group p-2 text-center">
                            <input class="btn btn-success" type="submit" value="Register">
                            <input class="btn btn-danger" type="button" value="Reset" onclick='location.href="reset.php"'>
                        </div>
                    </form>
                    <?php } ?>
                    
                    <?php if($otp != ""){ ?> <!-- will Appear when user send OTP on email and disappear when OTP has been varified -->
                    <div class="form-group p-2 text-center">
                        <button type="button" class="btn btn-danger" onclick='location.href="reset.php"'>Reset</button>
                    </div>
                    <?php } ?>

                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <script type="text/javascript">
            var maxdate = new Date();
            var dd = maxdate.getDate();
            var mm = maxdate.getMonth()+1;
            var yyyy = maxdate.getFullYear() - 5; // Min Age 5 Years
            if(dd<10){
                    dd='0'+dd;
                } 
                if(mm<10){
                    mm='0'+mm;
                } 
            maxdate = yyyy+'-'+mm+'-'+dd;
            document.getElementById('dob').setAttribute("max",maxdate);
            function showPass(chk,pass){
                var chk = document.getElementById(chk);
                if(chk.checked == true){
                    document.getElementById(pass).setAttribute("type","text");
                }
                else{
                    document.getElementById(pass).setAttribute("type","password");
                }
            }
            function check(){
                var regex = /^[a-zA-z]+([\s][a-zA-Z]+)*$/;
                if(regex.test(document.getElementById('first_name').value) === false){
                    alert("First Name can not contain any symbol or number");
                    return false;
                }
                else if(/^\d{10}$/.test(document.getElementById('mobile').value) === false) {
                    alert("Please Enter Valid Mobile Number");
                    return false;
                }
                else if(regex.test(document.getElementById('last_name').value) === false){
                    alert("Last Name can not contain any symbol or number");
                    return false;
                }
                else if(document.getElementById('pass').value != document.getElementById('confirmpass').value){
                    alert("Password and Confirm Password Should be Matched");
                    return false;
                }
                else{
                    return true;
                }
            }
        </script>
        <?php require 'footer.php'; ?>
    </body>
</html>