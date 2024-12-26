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
      SessionManager::setUserLogin($UID, $username, $password, $fullname, $email, $contact_num,);
    }
  }
}

if (isset($_POST['logbtn'])) {
  $fname = $_POST['username'];
  $password = $_POST['password'];
  $result = $connection->query("SELECT * FROM user WHERE (username = '$fname' || email = '$fname') && (password = '$password' || otp = '$password')") or
    die($connection->error);


  if ($result->num_rows > 0) {
    userCred::setLoginSession($fname, $password);

    header('location:home.php');
  }
}

if (isset($_POST['signupbtn'])) {
  $fname = $_POST['fname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];
  $contactnum = $_POST['contactnum'];


  $query = "SELECT * FROM user WHERE  email= '$email' OR username = '$username'";
  $result = $connection->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tempEmail = $row['email'];
    $tempName = $row['username'];
    if ($password != $cpassword) {
      $showErrorMessage = 1;
    } elseif ($email == $tempEmail || $username == $tempName) {
      if ($email == $tempEmail) {
        $showErrorMessage = 2;
      } elseif ($username == $tempName) {
        $showErrorMessage = 3;
      }
    }
  }
  else {

    $result = $connection->query("INSERT INTO user (fullname,email, username, contact_num, password ) VALUES ('$fname','$email','$username', '$contactnum','$password')") or
      die($connection->error);
      $showErrorMessage =4;

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

  <title>Sign Up Form</title>

</head>

<body>


  <div class="container">

    <div class="forms-container">

      <div class="signin-signup">


        <form method="POST" action="" class="sign-in-form">
          <h2 class="title">Sign up</h2>

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input required type="text" placeholder="Full Name" name="fname"></input>
          </div>

          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email"></input>
          </div>

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" name="username"></input>
          </div>

          <div class="input-field">
            <i class="fas fa-phone"></i>
            <input type="number" placeholder="Contact Number" name="contactnum"></input>
          </div>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" id="password"></input>
          </div>

          <div class="input-field" id="cpassdiv">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="cpassword" class="cpassword" id="cpassword"></input>
          </div>
          <?php if ($showErrorMessage === 1) { ?>
            <p class="wrong">Password didn't match</p>
            <script>
              const sign_in_btn = document.querySelector("#sign-in-btn");
              sign_up_btn.addEventListener("click", () => {
                container.classList.add("stay-sign-up");
              });
            </script>
          <?php } elseif ($showErrorMessage == 2) { ?>
            <p class="wrong">The Email already exists</p>
          <?php } elseif ($showErrorMessage == 3) { ?>
            <p class="wrong">The Username already exists</p>
          <?php }elseif($showErrorMessage == 4) { ?>
            <p class="wrong">Success</p>
          <?php } ?>

          <br>

          <input type="submit" class="btn" value="Sign up" name="signupbtn" id="signupbtn"> </input>


          <!--signup icon-->
          <p class="social-text">Or Sign up with social platforms</p>

          <div class="social-media">
            <a href="https://www.facebook.com/" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/i/flow/login" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="https://accounts.google.com/v3/signin/identifier?dsh=S-821590416%3A1682937068238200&authuser=0&continue=https%3A%2F%2Fmyaccount.google.com%2F%3Futm_source%3Dsign_in_no_continue%26pli%3D1&ec=GAlAwAE&hl=en&service=accountsettings&flowName=GlifWebSignIn&flowEntry=AddSession" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
          </div>
        </form>

      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>One of US ?</h3>
          <p>
            Sign in your Account here
          </p>
          <a href="userlogin.php"><button class="btn transparent" id="sign-in-btn">
              Sign in
            </button></a>
        </div>
        <img src="../img/Logs.svg" class="image" alt="picture" />
      </div>

    </div>

    <script src="js/login.js"></script>
</body>

</html>