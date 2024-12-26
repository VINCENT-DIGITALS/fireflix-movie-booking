<?php

use PhpParser\Node\Stmt\Static_;

require_once  '../System/sessionHandler.php';
session_start();
$MID =  $_SESSION['MID'];
class BookMovie
{
  public $MID;
  public $movie_name;
  public $showdate;

  public static function getAllMovies($MID)
  {
    global $connection;
    $current_date = date('Y-m-d');

    $sql = "SELECT * FROM movies WHERE MID='$MID'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {

      $movies = array();

      while ($row = $result->fetch_assoc()) {
        $movie = new BookMovie();

        $movie->movie_name = $row['movie_name'];
        $movie->showdate = $row['showdate'];

        $movies[] = $movie;
      }


      return $movies;
    } else {
    }
  }

  public static function setBook()
  {
  }
}



if (isset($_POST['submit'])) {

  if (isset($_POST['seats'])) {

  
  global $connection;
  $sql = $connection->query("SELECT * FROM movies WHERE MID='$MID'");
  if ($sql->num_rows > 0) {
    $row = $sql->fetch_assoc();
    $MID = $row['MID'];
    $showtime = $row['showdate'];
    $movie_name = $row['movie_name'];
    $seating_num = $_POST['seats'];
    adminSystem::setBooking($MID, $showtime, $movie_name, $seating_num);
    header('location:items.php');
  }
}

 
} else {
}
$movies = BookMovie::getAllMovies($MID);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="CSS/seatingStyle.css" />
  <title>Movie Seat Booking</title>
</head>

<body>

  <form method="POST" action="">
    <div class="movie-container">
      <label> Movie:</label>
      <select id="movie">
        <?php foreach ($movies as $movie) :
          if ($movie->archived_at == NULL) { //CHANGE TO SESSION


        ?>
            <tr>
              <option><?php echo $movie->movie_name; ?></option>
            </tr>
        <?php }
        endforeach ?>
      </select>

    </div>

    <ul class="showcase">
      <li>
        <div class="seat"></div>
        <small>Available</small>
      </li>
      <li>
        <div class="seat selected"></div>
        <small>Selected</small>
      </li>
      <li>
        <div class="seat sold"></div>
        <small>Sold</small>
      </li>
    </ul>

    <div class="container">

      <div class="screen"></div>
      <?php
      $n = 0;

      for ($r = 0; $r < 6; $r++) {
        for ($c = 0; $c < 25; $c++) {
          $n++;
          global $connection;
          $query = "SELECT * FROM booking WHERE   MID='$MID' AND seating_num= '$n'";
          $taken = $connection->query($query);
          if ($taken->num_rows > 0) {
            echo '<input type="checkbox" name="seats[]" class="seats" value="' . $n . '" disabled></input>';
          } else {
            echo '<input type="checkbox" name="seats[]" class="seat" value="' . $n . '" autocomplete="off"></input>';
          }
        }
      ?> <br>
      <?php  } ?>

    </div>
    <div class="next"> <input type="submit" name="submit" value="Next"></input> </div>

    </p>
  </form>


  <script src="js/Seatingscript.js"></script>
</body>

</html>