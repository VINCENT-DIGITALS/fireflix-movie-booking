<?php

use Review as GlobalReview;

include '../System/sessionHandler.php';
session_start();
$showempty = 0;
class Review
{

    public static function insertReviews($UID, $message)
    {
        global $connection;

        // Insert the movie data into the database
        $sql = $connection->query("INSERT INTO reviews(UID, review) VALUES('$UID', '$message')");
    }
}



$message = new Review();

if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
    $name = $_SESSION['fullname'];
    $email = $_SESSION['email'];
    $UID = $_SESSION['UID'];
    $user = $_SESSION['username'];
} else {
    $name = '';
}
if (isset($_POST['submit'])) {
    if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
        header('location:userlogin.php');
    } else {
        if (empty($_POST['message'])) {

            $showempty = 2;
        } elseif (isset($_POST['message'])) {
            $message = $_POST['message'];
            $showempty = 1;
            Review::insertReviews($UID, $message);
        } else {
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
    <title>Review us</title>
    <style>
        .ContactInfo {
            overflow: auto;

            max-height: 500px;
            padding: 2%;
            margin-right: 10%;

        }

        .ContactInfo textarea {
            background-color: transparent;
            color: white;
            font-size: 1rem;
            width: 400px;
            height: 100px;
            max-width: 400px;
            resize: none;
            border: none;
        }

        .ContactInfo::-webkit-scrollbar {
            display: none;
        }
        .ContactForm{
	display: flex;
	width: 600px;
	padding: 40px;
	background: #fff;
	overflow: hidden; /* add this */
	max-width: 600px;
}
.ContactForm form {
	max-width: 100%;
  }

.ContactForm h2{
	font-size: 30px;
	color: darkred;
	font-weight: 500;
}
.ContactForm .inputBox{
	position: relative;
	padding-right: 25%;
	width: 280%;
	margin-top: 10px;
	
}
.ContactForm .inputBox input,
.ContactForm .inputBox textarea{
	width: 90%;
	padding: 5px 0;
	font-size: 16px;
	margin: 10px 0;
	border:none;
	border-bottom: 2px solid #333;
	outline: none;
	resize: none;
	
}

    </style>
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
                <h2>Review Us </h2>
                <p>Welcome to the Review Us page for our cinema! We value all your feedback. So, please don't hesitate to review us. </p>
            </div>
            <div class="container">

                <div class="ContactInfo">
                    <?php
                    global $connection;

                    // Insert the movie data into the database
                    $sql = $connection->query("SELECT * FROM reviews WHERE approved_at IS NOT NULL ORDER BY time DESC");

                    if ($sql->num_rows > 0) {
                        while ($row = $sql->fetch_assoc()) { ?>

                            <div class="box" style=" border: 2px solid red; word-wrap: break-word; ">
                                <div class="text">
                                    <h3>anonymous</h3><br>
                                    <textarea disabled><?php echo $row['review']; ?></textarea>
                                    <p><?php echo $row['time']; ?></p>
                                </div>
                            </div>

                        <?php }
                    } else { ?>

                        <div class="box" style=" border: 2px solid red; word-wrap: break-word; ">
                            <div class="text">
                                <h3>anonymous</h3><br>
                                <textarea disabled>No reviews yet...</textarea>

                            </div>
                        </div>





                    <?php } ?>




                </div>
                <div class="ContactForm">
                    <form method="POST">
                        <h2>Submit Reviews</h2>


                        <div class="inputBox">
                            <input type="hidden" value="<?php echo $UID; ?>"></input>
                            <textarea name="message"></textarea>
                            <span>Your review...</span>
                        </div>
                        <?php
                        if ($showempty == 1) {
                            echo '<p> Your message has been sent!</p>';
                        } elseif ($showempty == 2) {
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