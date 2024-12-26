<?php            //LOG IN

include_once 'adminSystem.php';
session_start();

$showErrorMessage = 2;

if (isset($_POST['submit'])) {
	global $connection;
	$name = $_POST['username'];
	$password = $_POST['password'];
	$result = $connection->query("SELECT * FROM admin WHERE (username = '$name' || email = '$name') && password = '$password'") or
		die($connection->error);

	if ($result->num_rows > 0) {
		adminSystem::setlogin($name, $password);
		$showErrorMessage = false;
		header('location:dashboard.php');
	} else {
		$error = "Incorrect username or password";
		$showErrorMessage = true;
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Animated Login Form</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<img class="wave" src="img/bgs.jpg">
	<div class="container">
		<div class="img">
			<img src="img/Log.svg">
		</div>
		<div class="login-content">
			<form method="POST">
				<img src="img/avatars.jpg">
				<h2 class="title">Admin</h2>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
						<input type="text" name="username" class="input">
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" name="password" class="input">
					</div>
				</div>
				<?php if ($showErrorMessage === true) { ?>
					<p class="wrong">Wrong Email/Password</p>
				<?php } ?>
				<a href="#"></a>
				<input type="submit" name="submit" class="btn" value="Login">

			</form>
		</div>
	</div>
	<script type="text/javascript" src="js/addminlogin.js"></script>
</body>

</html>
<?php
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

?>