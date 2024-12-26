<?php

use PhpMyAdmin\SqlParser\Utils\Query;

include '../System/sessionHandler.php';
session_start();
adminSystem::adminReturn();;
// Define a class for handling movie data
class Movie
{
  // Define properties for movie data
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

  // Define a method for getting all non-archived movies from the database
  public static function getAllMovies()
  {
    global $connection; 
    $current_date = date('Y-m-d');
    $one_week_later = date('Y-m-d', strtotime($current_date . ' + 1 week'));
    $sql = "SELECT *, DATE_FORMAT(showdate, '%Y-%m-%d') AS showdate,  DATE_FORMAT(releasedate, '%Y-%m-%d') AS releasedate FROM movies WHERE archived_at IS NULL AND showdate>='$current_date' AND showdate<= '$one_week_later'  AND releasedate>'$current_date' ORDER BY MID DESC  ";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
      // Create an array to hold the movies
      $movies = array();

      // Loop through each row and create a Movie object for each movie
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
        // Add the Movie object to the movies array
        $movies[] = $movie;
      }

      // Return the movies array
      return $movies;
    } else {
      // Return an empty array if there are no movies
      return array();
    }
  }


}


if (isset($_POST['my_btn'])) {
  header("location:viewmovieadmin.php");
}
// Get all non-archived movies from the database
$movies = Movie::getAllMovies();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Now Showing Page</title>
  <link rel="stylesheet" type="text/css" href="css/style2.css">
  <script type="text/javascript" src="js/main.js"></script>

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
          <li class="choice"><a href="todayshow.php">Now Showing</a></li>
          <li class="choice"><a href="todaybooking.php">Booking</a></li>
          <li class="choice"><a href="services.php">Services</a></li>
          <li class="choice"><a href="reviews.php">Reviews</a></li>
        </ul>
      </div>
    </aside>
    <article class="content" style="margin-left: 32%;">
      <div class="display">
        <table>
          <?php
    
          # code...
         
          ?>
            <thead>

              <tr>
                <th>MID</th>
                <th>Movie Name</th>
                <th>Genre</th>
                <th>Duration</th>
                <th>Release Date</th>
                <th>Show Date</th>
                <th>Poster</th>

              </tr>
              <tr></tr>
              <tr></tr>
            </thead>
            <tbody class="action">
              <?php
              $count = 0;
              
              foreach ($movies as $movie) {
      
              ?>
                  <tr class="movies">
                    <td><?php echo $movie->MID; ?></td>
                    <td><?php echo $movie->movie_name; ?></td>
                    <td><?php echo $movie->genre; ?></td>
                    <td><?php echo $movie->running_time; ?></td>
                    <td><?php
                        if ($movie->archived_at !== NULL) { //if archived
                          echo "-";
                        } elseif ($movie->releasedate === '0000-00-00') {
                          echo "-";
                        } else {
                          echo $movie->releasedate;
                        }
                        ?>
                    </td>
                    <td><?php
                        if ($movie->archived_at !== NULL) { //if archived
                          echo "-";
                        } elseif ($movie->showdate === '0000-00-00') {
                          echo "-";
                        } else {
                          echo $movie->showdate;
                        }
                        ?>
                    </td>
                    <td><?php
                        if ($movie->poster === '') {
                          echo "-";
                        } else {
                          echo '<img class="display-poster" src="', $movie->poster, '" alt="poster" >';
                        }

                        ?></td>
                  </tr>
              <?php 
              } //end for each
              ?>
               
            </tbody>
          
        </table>
      </div>
    </article>
  </main>
  <script type="text/javascript" src="js/main.js"></script>
  <script>
    var currentUrl = window.location.href;

    // select all the links in the navigation menu
    var links = document.querySelectorAll(".options a");

    // initialize variables to track the currently active link and its index
    var activeLink = null;
    var activeIndex = -1;

    // loop through the links and compare their href attributes with the current URL
    for (var i = 0; i < links.length; i++) {
      if (links[i].href === currentUrl) {
        // add a class to the link and its parent <li> element to highlight it
        links[i].classList.add("active");
        links[i].closest("li").classList.add("active");
        links[i].style.color = "red";
        links[i].style.fontSize = "1.5em";

        // set the active link and index
        activeLink = links[i];
        activeIndex = i;
      }

      // add an event listener to each link that sets the active index when clicked
      links[i].addEventListener("click", function() {
        activeIndex = Array.prototype.indexOf.call(links, this);
      });
    }

    // add an event listener to the document to listen for arrow up and arrow down key presses
    document.addEventListener("keydown", function(event) {
      // only trigger the navigation if the active link is set and the key pressed is either arrow up or arrow down
      if (activeLink && (event.key === "ArrowUp" || event.key === "ArrowDown")) {
        // prevent default scrolling behavior
        event.preventDefault();

        // get the index of the next or previous link
        var newIndex = activeIndex;
        if (event.key === "ArrowUp") {
          newIndex--;
        } else {
          newIndex++;
        }
        if (newIndex < 0) {
          newIndex = links.length - 1;
        } else if (newIndex >= links.length) {
          newIndex = 0;
        }

        // trigger a click event on the next or previous link
        var newLink = links[newIndex];
        newLink.click();
      }
    });
    document.addEventListener("click", function(event) {
      // check if the target element of the click event is a link in the navigation menu
      if (event.target.matches(".options a")) {
        // set the active link and index
        activeLink = event.target;
        activeIndex = Array.prototype.indexOf.call(links, activeLink);
      } else {
        // reset the active link and index
        activeLink = null;
        activeIndex = -1;
      }
    });
  </script>
</body>

</html>