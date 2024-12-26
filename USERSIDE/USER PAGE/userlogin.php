<?php
include '../System/sessionHandler.php';
session_start();
$showErrorMessage = 0;
class userCred
{

  public static function setLoginSession($fname, $password)
  {
    global $connection;
    $sql = $connection->query("SELECT * FROM user WHERE (username = '$fname' || email = '$fname') && (password = '$password' || otp = '$password')");
    if ($sql->num_rows > 0) {
      $row = $sql->fetch_assoc();

      $UID = $row['UID'];
      $fullname = $row['fullname'];
      $username = $row['username'];
      $password = $row['password'];
      $email = $row['email'];
      $contact_num = $row['contact_num'];
      $removeOTP = $connection->query("UPDATE user SET otp=NULL WHERE UID='$UID'"); //REMOVE THE OTP 
      adminSystem::setUserLogin($UID, $username, $password, $fullname, $email, $contact_num,);
    }
  }
}
if (isset($_POST['guestbtn'])) {

    header('location:load.php');
}

if (isset($_POST['logbtn'])) {
  $fname = $_POST['username'];
  $password = $_POST['password'];
  $result = $connection->query("SELECT * FROM user WHERE (username = '$fname' || email = '$fname') && (password = '$password' || otp = '$password')") or
    die($connection->error);


  if ($result->num_rows > 0) {
    userCred::setLoginSession($fname, $password);

    header('location:load.php');
  }
}

if (isset($_POST['signupbtn'])) {
  $fname = $_POST['fname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];
  $contactnum = $_POST['contactnum'];


  $query = "SELECT * FROM user WHERE  email= '$email'";
  $result = $connection->query($query);
  if ($password != $cpassword) {
    $showErrorMessage = true;
  } elseif ($result->num_rows > 0) {
    $showErrorMessage = false;
  } else {

    $result = $connection->query("INSERT INTO user (fullname,email, username, contact_num, password ) VALUES ('$fname','$email','$username', '$contactnum','$password')") or
      die($connection->error);
  }
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

  <title>Login Form</title>

</head>

<body>


  <div class="container">

    <div class="forms-container">

      <div class="signin-signup">

        <form method="POST" class="sign-in-form">

          <h2 class="title">Sign in</h2>

          <!-- Login -->

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" name="username"></input>
          </div>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password"></input>
          </div>

          <a class="forgotpass" href="forgot-password.php">Forgot Password?</a>
          <br>
          <div class="home">
          <input type="submit" value="Login" class="btn solid" name="logbtn" />
          <input type="submit" value="GUEST" class="btn solid" name="guestbtn" />
          </div>
          <p class="social-text">Or Sign in with social platforms</p>
          <!--Icon-->
          <div class="social-media">
            <a target="_blank" href="https://www.facebook.com/" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a target="_blank" href="https://twitter.com/i/flow/login" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a target="_blank" href="https://accounts.google.com/v3/signin/identifier?dsh=S-821590416%3A1682937068238200&authuser=0&continue=https%3A%2F%2Fmyaccount.google.com%2F%3Futm_source%3Dsign_in_no_continue%26pli%3D1&ec=GAlAwAE&hl=en&service=accountsettings&flowName=GlifWebSignIn&flowEntry=AddSession" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
          </div>
          <!--signup -->

        </form>

      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here ?</h3>
          <p>
              Create your Account here
          </p>
          <a href="sign-up-form.php"><button class="btn transparent" id="sign-up-btn">
            Sign up
          </button></a>
        </div>
        <img src="../img/Logs.svg" class="image" alt="picture" />
      </div>
    </div>
  </div>

  <script src="js/login.js"></script>
</body>

</html>