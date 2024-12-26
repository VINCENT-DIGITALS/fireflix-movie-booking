<?php

use PhpMyAdmin\SqlParser\Utils\Query;

include 'adminSystem.php';
session_start();
adminSystem::return();
// Define a class for handling movie data
class Movie {
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
    public static function getAllMovies() {
        global $connection;
        $sql = "SELECT * FROM movies";
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

    // Define a method for archiving a movie in the database
    public static function archiveMovie($MID, $movie_name) {
        global $connection;
        $sql = "UPDATE movies SET archived_at=NOW() WHERE MID=$MID";
        $result = $connection->query($sql);
        if ($connection->query($sql) === TRUE) {
          //DO A PROMPT
          echo '<div id="my-panel" class="panel">
          <h2>You have Successfully Archived the Movie ',$movie_name,'!</h2>
          <Form method="POST"><button class="refresh-btn" type="submit" name="my_btn" id="close-btn">X</button></form>
          </div>';
          

        } else {
          echo "Failed to Archive movie data: " . $connection->error;
        }
    }
    public static function unarchiveMovie($MID,$movie_name) {
      global $connection;
      $sql = "UPDATE movies SET archived_at=NULL WHERE MID=$MID";
      
      if ($connection->query($sql) === TRUE) {
        //DO A PROMPT 
        echo '<div id="my-panel" class="panel">
              <h2>You have Successfully Unarchive the Movie ',$movie_name, '!</h2>
              <Form method="POST"><button class="refresh-btn" type="submit" name="my_btn" id="close-btn">X</button></form>
            </div>';
      } else {
        echo "Failed to UnArchive movie data: " . $connection->error;
      }
  }
}
if (isset($_POST['logout'])) {
  adminSystem::endSession();
}
// Handle archive action when a movie is clicked
if (isset($_POST['archived_at'])) {
    $MID = $_POST['MID'];
    $movie_name = $_POST['movie_name'];
    Movie::archiveMovie($MID,$movie_name);
}
if (isset($_POST['unarchive'])) {
  $MID = $_POST['MID'];
  $movie_name = $_POST['movie_name'];
  Movie::unarchiveMovie($MID,$movie_name);
}
if (isset($_POST['update'])) {
  $_SESSION['MID'] = $MID = $_POST['MID'];
   
  header('location:updatepage.php');
}
if (isset($_POST['my_btn'])) {
  header("location:updatemovies.php");
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
  <title>View Mvoies Page</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
  <!-- aos css cdn link  -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

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
        <li class="choice"><a href="dashboard.php">Home</a>
              <ul>
              <li class="nestedchoice" ><a href="addmovies.php"> Add Movie</a></li>
              <li class="nestedchoice" ><a href="updatemovies.php">Update Movies</a></li>
              </ul>
          </li>
         
          <li class="choice"><a href="todayshow.php">Today's Show</a></li>
          <li class="choice"><a href="todaybooking.php">Today's Booking</a></li>
          <li class="choice"><a href="services.php">Services</a></li>
          <li class="choice"><a href="reviews.php">Reviews</a></li>


        </ul>
      </div>
    </aside>
    <article class="content">
        <div class="display">
            <table class="viewtable" >
            <thead>
                <tr>
                    <th>MID</th>
                    <th>Movie Name</th>
                    <th>Synopsis</th>
                    <th>Genre</th>
                    <th>Duration</th>
                    <th>Release Date</th>
                    <th>Show Date</th>
                    <th>Action</th>
                </tr>
            </thead>  
            <tbody class="action">
                <?php foreach ($movies as $movie): ?>
                <tr class="movies">
                    <td><?php echo $movie->MID; ?></td>
                    <td><?php echo $movie->movie_name; ?></td>
                    <td class="long-text"><?php echo $movie->synopsis; ?></td>
                    <td><?php echo $movie->genre; ?></td>
                    <td><?php echo $movie->running_time; ?></td>
                    <td><?php
                            if ($movie->archived_at!== NULL ) { //if archived
                              echo "-";
                            }elseif($movie->releasedate=== '0000-00-00'){
                              echo "-";
                                
                            }else {
                              echo $movie->releasedate;
                            }
                        ?>
                    </td>
                    <td><?php
                          if ($movie->archived_at!== NULL ) { //if archived
                            echo "-";
                          }elseif($movie->showdate=== '0000-00-00'){
                            echo "-";
                              
                          }else {
                            echo $movie->showdate;
                          }
                            
                        ?>
                    </td>
                    <td >
                    <form method="post" action="">
                        <input type="hidden" name="MID" value="<?php echo $movie->MID; ?>">
                        <input type="hidden" name="movie_name" value="<?php echo $movie->movie_name; ?>">
                        <input class="archive_btn" type="submit" name="update" value="Edit">
                        <?php 
                          if ($movie->archived_at=== NULL) {
                          echo '<input class="archive_btn" type="submit" name="archived_at" value="Archive">';
                          }else{
                          echo '<input class="archive_btn" type="submit" name="unarchive" value="Unarchive">';
                          }
                        ?>
                        
                    </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody> 
            </table>
        </div>
    </article>
  </main>
  <script type="text/javascript" src="main.js"></script>
  <script>
    AOS.init();
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
