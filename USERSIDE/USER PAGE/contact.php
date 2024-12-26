<?php
include '../System/sessionHandler.php';
session_start();
$showempty = 0;
class Message
{


	public function insertMessageData($UID, $message)
	{

		global $connection;

		// Insert the movie data into the database
		$sql = "INSERT INTO messages (UID, message)
            VALUES ('$UID', '$message')";

		if ($connection->query($sql) === TRUE) {
		} else {
		}
		// Close the database connection
		$connection->close();
	}
}



$message = new Message();
if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
	$name = $_SESSION['fullname'];
	$email = $_SESSION['email'];
	$UID = $_SESSION['UID'];
}else {
	$name ='';
	$email = '';
}	
if (isset($_POST['submit'])) {
	if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
		header('location:userlogin.php');
	} else {
		if (empty($_POST['message'])) {
		
			$showempty = 2;
		}elseif(isset($_POST['message'])) {
			
			$showempty = 1;
			$message->insertMessageData($UID, $_POST['message']);
			
		}else {
			# code...
		}
	}
}


?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/57c2caf329.js" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/contact.css">
	<title>Contact us</title>
</head>

<body>

	<div class="banner" id="about">
		<div class="navbar">
			<img src="../img/fire.png" alt="" class="logo">
			<ul>
				<li><a href="home.php">Home</a></li>
				<li><a href="home.php">Movies</a></li>
				<li><a href="review.php">Reviews</a></li>
				<li><a href="aboutus.php">About Us</a></li>
				<li><a href="contact.php">Contact Us</a></li>
				<?php
				if (isset($_SESSION['username']) && isset($_SESSION['password'])) { ?>
					<li><a href="userlogout.php" id="logout-link">Logout</a></li>
				<?php } ?>

			</ul>
		</div>

		<section class="contact">
			<div class="content">
				<h2>Contact Us  </h2>
				<p>Welcome to the Contact Us page for our cinema! We're dedicated to providing you with the best movie experience possible and we value your feedback. If you have any questions, comments, or concerns, please don't hesitate to get in touch with us. </p>
			</div>
			<div class="container">
				<div class="ContactInfo">
					<div class="box">
						<div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></i></div>
						<div class="text">
							<h3>Address</h3>
							<p>Central Luzon State University,<br>Science City of Muñoz,<br> Nueva Ecija</p>
						</div>
					</div>

					<div class="box">
						<div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
						<div class="text">
							<h3>Contact Info</h3>
							<p>(+63)998-123-5123<br>(+63)982-232-3145</p>
						</div>
					</div>

					<div class="box">
						<div class="icon"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
						<div class="text">
							<h3>Email</h3>
							<p><a href="mailto:fireflixcompany@gmail.com" target="_blank"> fireflix@gmail.com</p></a>
						</div>
					</div>
				</div>
				<div class="ContactForm">
					<form method="POST">
						<h2>Send Message</h2>
						<div class="inputBox">
							<input type="text" name="name" value="<?php echo $name;?>"></input>
							<span>Full Name </span>
						</div>

						<div class="inputBox">
							<input type="text" name="email" value="<?php echo $email; ?>"></input>
							<span>Email</span>
						</div>

						<div class="inputBox">
							<input type="hidden" value="<?php echo $UID;?>"></input>
							<textarea name="message"></textarea>
							<span>Type your Message...</span>
						</div>
						<?php
							if ($showempty == 1) {
								echo '<p> Your message has been sent!</p>';
							}elseif($showempty == 2){
								echo '<p>Empty Message!</p>';
							}

						?>

						<div class="inputBox">
							<input type="submit" name="submit" value="Send">

						</div>

					</form>
				</div>
			</div>
		</section>

</body>

</html>