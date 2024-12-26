<?php

include '../System/sessionHandler.php';
session_start();

class Movie
{

    public $MID;
    public $movie_name;
    public $synopsis;
    public $running_time;
    public $price;
    public $discount;
    public $poster;
    public $archived_at;
    public $genre;
    public $trailer;
    public $releasedate;
    public $screen;
    public $showdate;

    public static function getAllMovies()
    {
        global $connection;
        $current_date = date('Y-m-d');
        $sql = "SELECT *, DATE_FORMAT(showdate, '%Y-%m-%d') AS showdate,  DATE_FORMAT(releasedate, '%Y-%m-%d') AS releasedate FROM movies WHERE archived_at IS NULL  AND releasedate>'0000-00-00' AND DATE(releasedate)<='$current_date' ORDER BY releasedate DESC  ";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {

            $movies = array();

            while ($row = $result->fetch_assoc()) {
                $movie = new Movie();
                $movie->MID = $row['MID'];
                $movie->movie_name = $row['movie_name'];
                $movie->synopsis = $row['synopsis'];
                $movie->running_time = $row['running_time'];
                $movie->price = $row['price'];
                $movie->discount = $row['discount'];
                $movie->poster = $row['poster'];
                $movie->archived_at = $row['archived_at'];
                $movie->genre = $row['genre'];
                $movie->trailer = $row['trailer'];
                $movie->releasedate = $row['releasedate'];
                $movie->screen = $row['screen'];
                $movie->showdate = $row['showdate'];

                $movies[] = $movie;
            }


            return $movies;
        } else {
        }
    }
    public static function upComing()
    {
        global $connection;
        $current_date = date('Y-m-d');

        $sql = "SELECT *, DATE_FORMAT(showdate, '%Y-%m-%d') AS showdate,  DATE_FORMAT(releasedate, '%Y-%m-%d') AS releasedate FROM movies WHERE archived_at IS NULL AND releasedate='$0000-00-00' || (DATE(releasedate)>'$current_date' AND DATE(showdate)>=DATE(releasedate)  ) ORDER BY MID DESC  ";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {

            $movies = array();

            while ($row = $result->fetch_assoc()) {
                $movie = new Movie();
                $movie->MID = $row['MID'];
                $movie->movie_name = $row['movie_name'];
                $movie->synopsis = $row['synopsis'];
                $movie->running_time = $row['running_time'];
                $movie->price = $row['price'];
                $movie->discount = $row['discount'];
                $movie->poster = $row['poster'];
                $movie->archived_at = $row['archived_at'];
                $movie->genre = $row['genre'];
                $movie->trailer = $row['trailer'];
                $movie->releasedate = $row['releasedate'];
                $movie->screen = $row['screen'];
                $movie->showdate = $row['showdate'];

                $movies[] = $movie;
            }


            return $movies;
        } else {
        }
    }
    public static function nowShowing()
    {
        global $connection;
        $current_date = date('Y-m-d');
        $one_week_later = date('Y-m-d', strtotime($current_date . ' + 1 week'));
        $sql = "SELECT *, DATE_FORMAT(showdate, '%Y-%m-%d') AS showdate,  DATE_FORMAT(releasedate, '%Y-%m-%d') AS releasedate FROM movies WHERE archived_at IS NULL AND DATE(showdate)>'0000-00-00' AND DATE(releasedate)<='$current_date' ORDER BY MID DESC  ";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {

            $movies = array();

            while ($row = $result->fetch_assoc()) {
                $movie = new Movie();
                $movie->MID = $row['MID'];
                $movie->movie_name = $row['movie_name'];
                $movie->synopsis = $row['synopsis'];
                $movie->running_time = $row['running_time'];
                $movie->price = $row['price'];
                $movie->discount = $row['discount'];
                $movie->poster = $row['poster'];
                $movie->archived_at = $row['archived_at'];
                $movie->genre = $row['genre'];
                $movie->trailer = $row['trailer'];
                $movie->releasedate = $row['releasedate'];
                $movie->screen = $row['screen'];
                $movie->showdate = $row['showdate'];

                $movies[] = $movie;
            }


            return $movies;
        } else {
        }
    }
}

$movies = Movie::getAllMovies();
$nowshowing = Movie::nowShowing();
$upcoming = Movie::upComing();
if (isset($_POST['booknow'])) {

    if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
        header('location:userlogin.php');
    } else {
        adminSystem::setBooking($_POST['MID'], null, null, null, null, null,);
        header('location:seating.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;900&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>


    <link rel="stylesheet" href="CSS/home.css">
    <title>FireFlix</title>
</head>

<body>
    <div class="banners" id="home">
        <video autoplay muted loop>
            <source src="../images/aver-002.mp4" type="video/mp4">
        </video>
    </div>




    <div class="banner">
        <div class="navbar">
            <img src="../images/fire.png" alt="" class="logo">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#product">Movies</a></li>
                <li><a href="review.php">Reviews</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <?php
                if (isset($_SESSION['username']) && isset($_SESSION['password'])) { ?>
                    <li><a href="userlogout.php" id="logout-link">Logout</a></li>
                <?php } ?>

            </ul>
        </div>

        <div class="content">
            <h1>Fire<span>Flix</span></h1>
            <p>Catch films as they glow in the dark, and experience the warmth from the lights</p>
            <?php
            if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
            } else { ?>
                <div>
                    <a href="sign-up-Form.php"><button class="signup-btn" type="button"><span class="cover"></span>SIGN UP</button></a>
                    <a href="userlogin.php"><button class="login-btn" type="button"><span class="cover"></span>LOG IN</button></a>
                </div>
            <?php } ?>

        </div>
    </div>

    <section class="product" id="product">

        <h2 class="product-category">New Releases</h2>
        <button class="pre-btn"><img src="images/arrow.png" alt=""></button>
        <button class="nxt-btn"><img src="images/arrow.png" alt=""></button>
        <div class="product-container">
            <?php
            foreach ($movies as $movie) {


            ?>
                <form action="" method="post">
                    <input type="text" hidden name="MID" value="<?php echo $movie->MID; ?>"></input>
                    <div class="product-card">
                        <div class="product-image">
                            <span class="discount-tag"></span>

                            <?php echo '<img src="', $movie->poster, '" class="product-thumb" alt="">'; ?>
                            <div disabled type="submit" name="booknow" class="card-btn"><?php echo $movie->synopsis;  ?></div>
                            <button type="submit" name="booknow" class="card-btn">Buy Ticket</button>
                        </div>
                        <div class="product-info">
                            <h2 class="product-brand"><?php echo $movie->movie_name; ?></h2>
                            <p class="product-short-description"></p>
                            <span class="price"></span><span class="actual-price"></span>
                        </div>
                    </div>
                </form>
            <?php
            } ?>
        </div>
    </section>

    <section class="product">

        <h2 class="product-category">Now Showing</h2>
        <button class="pre-btn"><img src="images/arrow.png" alt=""></button>
        <button class="nxt-btn"><img src="images/arrow.png" alt=""></button>
        <div class="product-container">
            <?php
            foreach ($nowshowing as $movie) {


            ?>
                <form action="" method="post">
                    <input type="text" hidden name="MID" value="<?php echo $movie->MID; ?>"></input>
                    <div class="product-card">
                        <div class="product-image">
                            <span class="discount-tag"></span>
                            <?php echo '<img src="', $movie->poster, '" class="product-thumb" alt="">' ?>
                            <div disabled type="submit" name="booknow" class="card-btn"><?php echo $movie->synopsis;  ?></div>
                            <button type="submit" name="booknow" class="card-btn">Buy Ticket</button>
                        </div>
                        <div class="product-info">
                            <h2 class="product-brand"><?php echo $movie->movie_name; ?></h2>
                            <p class="product-short-description"></p>
                            <span class="price"></span><span class="actual-price"></span>
                        </div>
                    </div>
                </form>

            <?php

            } ?>
        </div>
    </section>

    <section class="product">
        <?php
        global $connection;
        $current_date = date('Y-m-d');
        $sql = "SELECT *, DATE_FORMAT(showdate, '%Y-%m-%d') AS showdate,  DATE_FORMAT(releasedate, '%Y-%m-%d') AS releasedate FROM movies WHERE archived_at IS NULL AND releasedate<'$current_date'  ORDER BY MID DESC  ";
        $result = $connection->query($sql);




        if ($result->num_rows > 0) {
            # code...

        ?>
            <h2 class="product-category">Upcoming Movies</h2>
            <button class="pre-btn"><img src="images/arrow.png" alt=""></button>
            <button class="nxt-btn"><img src="images/arrow.png" alt=""></button>
            <div class="product-container">
                <?php
                foreach ($upcoming as $movie) {



                ?>
                    <form action="" method="post">
                        <input type="text" hidden name="MID" value="<?php echo $movie->MID; ?>"></input>
                        <div class="product-card">
                            <div class="product-image">
                                <span class="discount-tag"></span>
                                <?php echo '<img src="', $movie->poster, '" class="product-thumb" alt="">'; ?>
                                <div type="submit" name="booknow" class="card-btn"><?php echo $movie->synopsis;  ?></div>
                            </div>
                            <div class="product-info">
                                <h2 class="product-brand"><?php echo $movie->movie_name; ?></h2>
                                <p class="product-short-description"></p>
                                <span class="price"></span><span class="actual-price"></span>
                            </div>
                        </div>
                    </form>


                <?php
                }
            } else { ?>
                <h2 class="product-category">No Upcoming Movies</h2>
                <button class="pre-btn"><img src="images/arrow.png" alt=""></button>
                <button class="nxt-btn"><img src="images/arrow.png" alt=""></button>
                <div class="product-container">
                <?php } ?>
                </div>
    </section>

    <script src="js/home.js"></script>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>



    <div>
        <footer>
            <div class="row">
                <div class="col">
                    <img src="../images/fire.png" class="logo">
                    <p> subscribe </p>
                </div>
                <div class="col">
                    <h3>CONTACT INFO <div class="underline"><span></span></div>
                    </h3>
                    <p>PWJH+3XC, Central Luzon State University, Science City of Muñoz, Nueva Ecija</p>
                    <p class="email-id"><a target="_blank" href="mailto:fireflixcompany@gmail.com"> Fireflix@gmail.com </a></p>
                    <h4>+63 997 321 3124</h4>
                </div>
                <div class="col">
                    <h3>Links <div class="underline"><span></span></div>
                    </h3>
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="#product">Movies</a></li>
                        <li><a href="review.php">Reviews</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h3>Subscribe<div class="underline"><span></span></div>
                    </h3>
                    <form>
                        <i class="far fa-envelope"></i>
                        <input type="email" placeholder="Enter your email id" required>
                        <button_type="submit"><i class="fas fa-arrow-right"></i></button>
                    </form>
                </div>
                <div class="social-icons">
                    <a href="https://www.facebook.com/profile.php?id=100092261810371" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank"></a><i class="fab fa-twitter"></i></a>
                    <a href="https://www.whatsapp.com/" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.pinterest.ph/" target="_blank"><i class="fab fa-pinterest"></i></a>
                </div>
        </footer>
    </div>

    </div>
</body>

</html>


