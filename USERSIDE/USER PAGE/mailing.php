<?php
require_once 'vendor/autoload.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';



use mikehaertl\wkhtmlto\Image;
use mikehaertl\wkhtmlto\Pdf;
use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class mailingSystem
{
  public static function bookingConfirm() //to use this statement create new object then $objectname->bookingConfirm();
  {

    $mpdf = new \Mpdf\Mpdf();

    $mpdf->SetMargins(0, 0, 80);

    // Set font size to 10pt
    $mpdf->SetDefaultFontSize(10);

    // Disable auto page break
    $mpdf->SetAutoPageBreak(false);
    $mpdf->AddPage('P');

    // Get the HTML content of your PHP file
    ob_start();
    include('ticketDesign.php');
    $html = ob_get_clean();


    // Add the HTML content to the PDF
    $mpdf->WriteHTML($html);

    $pdfname = '../tickets/' . $cname . '_ticket.pdf';
    // Save the PDF to a file
    $mpdf->Output($pdfname, \Mpdf\Output\Destination::FILE);

    $email =  $_SESSION['email'];
    $mail = new PHPMailer();

    $mail->isHTML(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fireflixcompany@gmail.com';
    $mail->Password = 'gwdt jnqo vzro xjxu';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('fireflixcompany@gmail.com', 'Fireflix');
    $mail->addAddress($email, $cname);
    $mail->Subject = 'Booking Confirmation';
    $mail->Body = '<p style = "text-transform:uppercase;">Hi, ' . $cname . '. Your ticket for the movie ' . $movie . ' has been successfully generated.<p>';

    $mail->addAttachment($pdfname, $cname . '_Ticket.pdf');


    //for ($i = 0; $i < 5; $i++) {
    // Add another attachment with a different filename
    // $mail->addAttachment($tempFile, 'generated_image_' . $i . '.png');
    // }
    //$mail->addAttachment($tempFile, 'generated_image_.png');
    try {
      //server with default setting (user 'root' with no password)
      $host = 'localhost';  // server 
      $user = 'root';
      $pass = "";
      $database = 'fireflixdb';   //Database Name  
      $connection = new mysqli($host, $user, $pass, $database);
    
  } catch (Exception $e) {
      echo "Error connecting to database: " . $e->getMessage();
  }
  global $connection;
  $MID = $_SESSION['MID'];
  $sql = $connection->query("SELECT price, discount FROM movies WHERE MID='$MID'");
  if ($sql->num_rows > 0) {
      while ($row = $sql->fetch_assoc()) {
          $price = $row['price'];
          $discount = $row['discount'];
      }
  }

    if($mail->send()){
   
      $seats = $_SESSION['seating_num'];
      foreach ($seats as $seat) {
        # code...
        
        $UID = $_SESSION['UID'];
        $MID = $_SESSION['MID'];
        $discounted = $price * ($discount / 100);
        $total_cost =$price - $discounted;
        $sql = $connection->query("INSERT INTO booking(UID,MID,seating_num, total_cost ) VALUES('$UID','$MID','$seat',$total_cost) ");
        
     
      }
    }


    return 1;
 
  }

  public static function forgotPass($UID, $username, $password, $fullname, $email, $contact_num)
  { //to use this statement create new object then $objectname->forgotPass();
    

    $mail = new PHPMailer();

    $mail->isHTML(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fireflixcompany@gmail.com';
    $mail->Password = 'gwdt jnqo vzro xjxu';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    $otp = self::otPass();
    $mail->setFrom('fireflixcompany@gmail.com', 'Fireflix');
    $mail->addAddress($email, $fullname);
    $mail->Subject = 'Your One-Time Password from Fireflix';
    $mail->Body = '<p>Hi, ' . $fullname . ',<p>';
    $mail->Body .= '<p  style = "text-transform:uppercase;">Beware of Scams. NEVER SHARE YOUR OTP WITH ANYONE!</p>';
    $mail->Body .= '<p>Please use the 6-digit code as your password.</p>';
    $mail->Body .= '<p>Remember, this OTP can only be used once. </p>'; 
    $mail->Body .= '<br><h1>'.$otp.'<h1>'; 



    global $connection;
    $connection->query("UPDATE user SET otp='$otp' WHERE UID='$UID'"); 
    $mail->send();
  }
  public static function messageReply( $fullname, $email, $reply)
  { //to use this statement create new object then $objectname->forgotPass();
    

    $mail = new PHPMailer();

    $mail->isHTML(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fireflixcompany@gmail.com';
    $mail->Password = 'gwdt jnqo vzro xjxu';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    $otp = self::otPass();
    $mail->setFrom('fireflixcompany@gmail.com', 'Fireflix');
    $mail->addAddress($email, $fullname);
    $mail->Subject = 'Reply from Fireflix';
    $mail->Body = '<p>Hi, ' . $fullname . ',<p>';
    $mail->Body .= '<p>'. $reply.'</p>';
    

    $mail->send();
  }

  public static function otPass() {
      global $connection;
      do {
        $otp = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 5); // generate random string of 5 characters
        $query = "SELECT * FROM user WHERE  otp= '$otp'";
        $result = $connection->query($query);
    } while ($result->num_rows > 0);
    return $otp;
  }
}
