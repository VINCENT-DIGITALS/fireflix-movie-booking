<?php
include '../System/sessionHandler.php';
include '../USER PAGE/mailing.php';

session_start();
adminSystem::adminReturn();

$name = '';
$email = '';
$message= '';

class updateMessage{

    public static function Message($MessageID, $fullname, $reply, $email){
        global $connection;
        $sql = "UPDATE messages SET replied_at=NOW() WHERE MessageID='$MessageID'";
        if ($connection->query($sql) === TRUE) {
            mailingSystem::messageReply( $fullname, $email, $reply); 
            header('location:message.php');
        } 
    }
}


if (isset( $_SESSION['fname']) && isset( $_SESSION['email'])) {
  $name =  $_SESSION['fname'];
  $MessageID =$_SESSION['MessageID'];
  $email =  $_SESSION['email'];
  $message= $_SESSION['message'];
}

if (isset($_POST['submitreply'])) {
    
    $fullname = $_POST['name'];
    $reply = $_POST['reply'];
    $email = $_POST['email'];
    updateMessage::Message($_SESSION['MessageID'], $fullname, $reply, $email);
  }
if (isset($_POST['back'])) {
    header('location:message.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reply Form</title>
  <link rel="stylesheet" type="text/css" href="css/style2.css">
  <!-- aos css cdn link  -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<STYle>
    body{
        background-color: wheat;
    }
</STYle>
</head>

<body>

<div class="form-popup" id="contactForm">
    <form id="popform" method="post">
      <h2>Contact Us</h2>
      <label for="name">Name</label>
      <input type="text" id="namepop" name="name" value="<?php echo $name?>" required>

      <label for="email">Email</label>
      <input type="email" id="emailpop" name="email" value="<?php echo $email?>" required>

      <label for="message">Message</label>
      <textarea id="message" name="message"><?php echo $message; ?></textarea>

      <label for="message">Reply</label>
      <textarea id="reply" name="reply"></textarea>

      <button type="submit" name="submitreply" class="submitpopup">Submit</button>
      <button type="button" name="back" class="btn">Close</button>
    </form>
  </div>

  <script type="text/javascript" src="js/main.js"></script>
</body>

</html>