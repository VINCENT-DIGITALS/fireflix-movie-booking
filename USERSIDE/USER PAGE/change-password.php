<?php
include '../System/sessionHandler.php';
session_start();
include_once 'mailing.php';

$showErrorMessage = 2;


if (isset($_POST['forgotbtn'])) {
  $email_number = $_POST['email-number'];
  $sql = $connection->query("SELECT * FROM user WHERE contact_num = '$email_number' || email = '$email_number'") or
    die($connection->error);

  if ($sql->num_rows > 0) {
    $row = $sql->fetch_assoc();

    $UID = $row['UID'];
    $fullname = $row['fullname'];
    $username = $row['username'];
    $password = $row['password'];
    $email = $row['email'];
    $contact_num = $row['contact_num'];


    $showErrorMessage = false;
    mailingSystem::forgotPass($UID, $username, $password, $fullname, $email, $contact_num);
  } else {
    $showErrorMessage = true;
  }
}

if (isset($_POST['update'])) {
  

  $otp =  $_POST['otp'];
  $newpassword =  $_POST['npassword'];

  global $connection;
  $SQLUpdate = $connection->query( "UPDATE user SET password='$newpassword' WHERE otp='$otp'"); 
  
  $select =$connection->query("SELECT * FROM user WHERE otp='$otp'");

  if ($select->num_rows > 0) {
    $row = $select->fetch_assoc();
    $UID = $row['UID'];
    $removeOTP = $connection->query("UPDATE user SET otp=NULL WHERE UID='$UID'"); //REMOVE THE OTP 
    header('location:userlogin.php');
  } 

}

if (isset($_POST['return'])) {
  header('location:userlogin.php');
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous">
  </script>

  <link rel="stylesheet" href="CSS/loginstyle.css" />

  <title>Forgot Password Form</title>

</head>

<body>


  <div class="container">

    <div class="forms-container">

      <div class="signin-signup">

      

        <form method="POST" action="" class="sign-in-form">
          <h2 class="title">New Password</h2>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="OTP" name="otp" id="otp"></input>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="text" placeholder="New Password" name="npassword" id="password"></input>
          </div>
          <div class="input-field" id="cpassdiv">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="cpassword" class="cpassword" id="cpassword"></input>
          </div>
    
          <input type="submit" class="btn" value="Update" name="update" id="signupbtn"> </input>
        </form>
      </div>

    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Don't have OTP ?</h3>
          <p>
          Get your OTP here
          </p>
          <a href="forgot-password.php"><button class="return" id="sign-up-btn">
          One Time Password
          </button></a>
        </div>
        <img src="../img/Logs.svg" class="image" alt="picture" />
      </div>


    </div>
  </div>

  <script src="js/login.js"></script>

</body>

</html>