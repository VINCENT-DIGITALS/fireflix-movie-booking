<?php

include '../System/sessionHandler.php';
session_start();
adminSystem::adminReturn();

class Movie
{

  public $MID;
  public $movie_name;
  public $synopsis;
  public $running_time;
  public $price;
  public $discount;
  public $poster;
  public $genre;
  public $trailer;
  public $releasedate;
  public $showdate;
  // Define a method for inserting the movie data into the database
  public function UpdateMovieData()
  {
    // Connect to the database
    global $connection;

    // Insert the movie data into the database
    $movie_name_escaped = mysqli_real_escape_string($connection, $this->movie_name);
    $synopsis_escaped = mysqli_real_escape_string($connection, $this->synopsis);
    $sql = "UPDATE movies SET movie_name='$movie_name_escaped', synopsis='$synopsis_escaped', running_time='$this->running_time', price='$this->price', discount='$this->discount', poster='$this->poster', genre='$this->genre',releasedate='$this->releasedate', trailer='$this->trailer', showdate='$this->showdate' WHERE MID='$this->MID'";

    if ($connection->query($sql) === TRUE) {
      header('location:updatemovies.php');
    } else {
      echo "Error inserting movie data: " . $connection->error;
    }
  }
}

$movie = new Movie();

if (isset($_SESSION['MID'])) {
  $MID = $_SESSION['MID'];
  global $connection;
  $sql = "SELECT * FROM movies WHERE MID='$MID'";
  $result = $connection->query($sql);

  if ($row = $result->fetch_assoc()) {
    $movie = new Movie();
    $MID = $row['MID'];

    $movie_name = $row['movie_name'];
    $synopsis = $row['synopsis'];
    $running_time = $row['running_time'];
    $price = $row['price'];
    $discount = $row['discount'];
    $poster = $row['poster'];
    $archived_at = $row['archived_at'];
    $genre = $row['genre'];
    $trailer = $row['trailer'];
    $releasedate = $row['releasedate'];
    $screen = $row['screen'];
    $showdate = $row['showdate'];
  }
}



if (isset($_POST['submit'])) {
  $movie->MID = $_SESSION['MID'];
  $movie->movie_name = $_POST['movie_name'];
  $movie->synopsis = $_POST['synopsis'];
  $movie->running_time = $_POST['running_time'];
  $movie->price = $_POST['price'];
  $movie->discount = $_POST['discount'];
  $movie->genre = $_POST['genre'];
  $movie->releasedate = $_POST['releasedate'];
  $movie->showdate = $_POST['showdate'];
  $movie->trailer = $_POST['trailer'];

  // Get the filename and temporary file location
  $filename = $_FILES['poster']['name'];
  $tmpname = $_FILES['poster']['tmp_name'];

  // Move the file to a folder on your server
  $folder = '../images/movie_posters/';
  move_uploaded_file($tmpname, $folder . $filename);

  // Set the picture variable to the filename
  $movie->poster = $folder . $filename;

  // Insert the movie data into the database

  $movie->UpdateMovieData();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Movie Form</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <main>
    <header class="head">
      <div class="logo">
        <img src="../img/FireFlix Logo (No Background).png" alt="logo">
      </div>
      <ul id="menu">
        <li class="items">
        <li class="message"><a href="message.php" class="ms"> Message</a></li>
        <li class="message"><a href="adminlogout.php" class="ms"> Logout </a></li>
        </li>
      </ul>
    </header>
    <aside class="dashboard">
      <div class="profile">
        <!--<span class="admin_prof"><img src="img/admin-logo-clipart-3.png" alt="logo"></span>-->
        <p>Administration Dashboard <img src="../img/activestatus.png" alt="active status"></p>
      </div>
      <br><br>
      <div>
        <ul class="options">
          <li class="choice"><a href="dashboard.php">Home</a></li>
          <li class="choice"><a href="addmovies.php">Add Movies</a></li>
          <li class="choice"><a href="updatemovies.php">Update Movies</a></li>

          <li class="choice"><a href="todayshow.php">Now Showing</a></li>
          <li class="choice"><a href="todaybooking.php">Booking</a></li>
          <li class="choice"><a href="services.php">Services</a></li>
          <li class="choice"><a href="reviews.php">Reviews</a></li>
        </ul>
      </div>
    </aside>
    <article class="content">
      <div class="form">
        <div class="forminput">
          <form method="post" enctype="multipart/form-data">
            <div class="others">
              <label>MID:</label>
              <input disabled required type="text" name="movie_name" value="<?php echo $MID ?>" autofocus></input><br>

              <label>Movie Name:</label>
              <input required type="text" name="movie_name" value="<?php echo $movie_name ?>" autofocus></input><br>

              <label>Poster:</label>
              <input required id="poster" type="file" name="poster" accept="image/*"></input><br>

              <label>running_time (in minutes):</label>
              <input type="number" name="running_time" value="<?php echo $running_time ?>"></input><br>

              <label>Genre:</label>
              <input required type="text" name="genre" value="<?php echo $genre ?>"></input><br>

              <label>Trailer:</label>
              <input required id="trailer" type="text" name="trailer" value="<?php echo $trailer ?>"></input><br>

              <label>Price:</label>
              <input required type="number" name="price" value="<?php echo $price ?>"></input><br>

              <label>Discount:</label>
              <input type="number" name="discount" value="<?php echo $discount ?>"></input><br>

              <label>Release Date:</label>
              <input type="datetime-local" name="releasedate" value="<?php echo $releasedate ?>"></input><br>

              <label>Show Date:</label>
              <input type="datetime-local" name="showdate" value="<?php echo $showdate ?>"></input><br>
            </div>

            <div class="synopsis"><label>Synopsis:</label>
              <textarea required class="textarea" type="text" name="synopsis"><?php echo $synopsis ?></textarea><br>
            </div>

            <input required class="submit" type="submit" name="submit" value="Update"></input>
          </form>
        </div>
        <div class="poster">

          <img id="img" src="../img/choose.png" alt="poster" height="300px">
        </div>

      </div>
    </article>
  </main>
  <script type="text/javascript" src="js/main.js"></script>
  <script>
    var posterPath = '<?php echo $poster ?>';
    if (posterPath) {
      var file = new File([posterPath], posterPath);
      document.getElementById('poster').files[0] = file;
    }
    var currentUrl = window.location.href;

    // select all the links in the navigation menu
    var links = document.querySelectorAll(".options a");

    // loop through the links and compare their href attributes with the current URL
    for (var i = 0; i < links.length; i++) {
      if (links[i].href === currentUrl) {
        // add a class to the link and its parent <li> element to highlight it
        links[i].classList.add("active");
        links[i].closest("li").classList.add("active");
        links[i].style.color = "red";
        links[i].style.fontSize = "2em";
      }
    }
  </script>
</body>

</html>