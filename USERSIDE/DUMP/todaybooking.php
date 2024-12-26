<?php

use PhpMyAdmin\SqlParser\Utils\Query;
include 'adminSystem.php';
session_start();
adminSystem::return();
// Define a class for handling movie data
class Movie {
    // Define properties for movie data
    public $MID;
    public $UID;
    public $AID;
    public $SID;
    public $ticket;
    public $total_cost;
    public $booked_at;
    public $fullname;

    public $movie_name;
    public $archived_at;

    
    // Define a method for getting all non-archived movies from the database
    public static function getAllMovies() {
        global $connection;
        $sql = "SELECT booking.BID, booking.ticket, booking.total_cost, booking.booked_at, movies.MID, movies.movie_name,movies.archived_at ,movies.running_time, movies.poster, movies.showdate, user.UID, user.fullname, seating.SID
        FROM booking 
        INNER JOIN movies 
        ON movies.MID = booking.MID 
        INNER JOIN user 
        ON user.UID = booking.UID 
        INNER JOIN seating 
        ON seating.SID = booking.SID;
        ";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            // Create an array to hold the movies
            $movies = array();

            // Loop through each row and create a Movie object for each movie
            while ($row = $result->fetch_assoc()) {
                $movie = new Movie();
                $movie->MID = $row['MID'];
                $movie->movie_name = $row['movie_name'];
                $movie->fullname = $row['fullname'];
                $movie->running_time = $row['running_time'];
                $movie->total_cost = $row['total_cost'];
                $movie->booked_at = $row['booked_at'];
                $movie->poster = $row['poster'];
                $movie->ticket = $row['ticket'];

                $movie->showdate = $row['showdate'];
                $movie->archived_at = $row['archived_at'];

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
$movies = Movie::getAllMovies();

if (isset($_POST['logout'])) {
  adminSystem::endSession();
}
if (isset($_POST['my_btn'])) {
  header("location:viewmovieadmin.php");
}
// Get all non-archived movies from the database


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Mvoies Page</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
  <script type="text/javascript" src="main.js"></script>
  
</head>
<body>
  <main>
  <header class="head">
    <div class="logo">
        <img src="img/FireFlix Logo (No Background).png" alt="logo">
    </div>
    <ul id="menu">
            <li class="items">
                <form method="post">
                  <button class="lg" type="submit" name="logout" value="Logout">Logout</button>
                </form>
            </li>
        </ul>
    </header>
    <aside class="dashboard">
      <div class="profile">
        <!--<span class="admin_prof"><img src="img/admin-logo-clipart-3.png" alt="logo"></span>-->
        <p>Administration Dashboard <img src="img/activestatus.png" alt="active status"></p>
      </div>
      <br><br>
      <div>
        <ul class="options">
          <li class="choice"><a href="dashboard.php">Home</a></li>
          <li class="choice"><a href="todayshow.php">Today's Show</a></li>
          <li class="choice"><a href="todaybooking.php">Today's Booking</a></li>
          <li class="choice"><a href="services.php">Services</a></li>
          <li class="choice"><a href="reviews.php">Reviews</a></li>
        </ul>
      </div>
    </aside>
    <article class="content">
        <div class="display">
            <table>
            <?php 
                   $current_date = date('Y-m-d');
                  global $connection;
                  $sql = "SELECT * FROM booking WHERE booked_at ='$current_date' ";
                  $result = $connection->query($sql);
                
                  if ($row = $result->fetch_assoc()) {
              ?>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>User Name</th>
                    <th>Movie Name</th>
                    <th>Seating Number</th>
                    <th>Cost</th>
                    <th>Book Today</th>
                    <th>Show Date</th>
                    <th>Poster</th>

                </tr>
                <tr></tr><tr></tr>
            </thead>  
            <tbody class="action">
                <?php 
                    $count=0;
                  $current_date = date('Y-m-d');
                  foreach ($movies as $movie): 
                  if ($movie->booked_at === $current_date && $movie->archived_at== NULL ) {
                    $count++;
                  
                ?>
                <tr class="movies">
                    <td><?php echo $count; ?></td>
                    <td><?php echo $movie->fullname; ?></td>
                    <td><?php echo $movie->movie_name; ?></td>
                    <td><?php echo $movie->SID; ?></td>
                    <td><?php echo $movie->total_cost; ?></td>
                    <td><?php echo $movie->booked_at; ?></td>
                    <td><?php echo $movie->showdate; ?></td>
                    <td><?php 
                            if ($movie->poster === '') {
                                echo "-";
                            }else{
                                echo '<img class="display-poster" src="',$movie->poster,'" alt="poster" >';
                            }
                        
                        
                    ?></td>
                </tr>
                <?php } endforeach; ?>
            </tbody> 
            <?php } else { ?>
                <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td>
                  <td style="font-size: 50px;">No shows today</td>
                  <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
            <?php  }?>
            </table>
        </div>
    </article>
  </main>
  <script type="text/javascript" src="main.js"></script>
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
    links[i].style.fontSize = "1.4em";

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
