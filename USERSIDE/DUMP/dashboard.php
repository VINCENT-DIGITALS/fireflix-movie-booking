<?php

use PhpMyAdmin\SqlParser\Utils\Query;
include 'adminSystem.php';
session_start();
adminSystem::return();


class Movie {
  
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
  
    public static function getAllMovies() {
        global $connection;
        $sql = "SELECT * FROM movies";
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

            return array();
        }
    }

    public static function archiveMovie($MID, $movie_name) {
        global $connection;
        $sql = "UPDATE movies SET archived_at=NOW() WHERE MID=$MID";
        $result = $connection->query($sql);
        if ($connection->query($sql) === TRUE) {
          //DO A PROMPT
          echo '<div id="my-panel" class="panel">
          <h2>You have Successfully Archived the Movie !</h2>
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
// Handle action when a action is clicked
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
   
  header('location:updatemovie.php');
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
  <title>View Mvoies Page</title>
  <!-- aos css cdn link  -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
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
          <li class="choice" ><a href="dashboard.php" style="transition: 0.5s;">Home</a>
              <ul>
              <li class="nestedchoice" data-aos="fade-right"  data-aos-easing="linear" data-aos-duration="500"><a href="addmovies.php">Add Movie</a></li>
              <li class="nestedchoice" data-aos="fade-right"  data-aos-easing="linear" data-aos-duration="500"><a href="updatemovies.php">Update Movies</a></li>
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
            <table>
            <thead>
                <tr><th>MID</th>
                    <th>Movie Name</th>
                    <th>Genre</th>
                    <th>Poster</th>
                    <th>Release Date</th>
                    <th>Show Date</th>
                </tr>
                <tr></tr><tr></tr>
            </thead>  
            <tbody class="action">
                <?php foreach ($movies as $movie): 
                  if ($movie->archived_at=== NULL) {
                    # code...
                  ?>
                <tr class="movies">
                    <td><?php echo $movie->MID; ?></td>
                    <td><?php echo $movie->movie_name; ?></td>
                    <td><?php echo $movie->genre; ?></td>
                    <td><?php 
                            if ($movie->poster === '') { // or !(substr($movie->poster, 0, 5)) == 'posters/'
                                echo "-";
                            }else{
                                echo '<img class="display-poster" src="',$movie->poster,'" alt="poster" >';
                            }
                        
                        
                        ?></td>
                    <td><?php
                            if ($movie->archived_at=== NULL && $movie->showdate === '0000-00-00') {
                                echo $movie->releasedate;
                            }else{
                                echo "-";
                                
                            }
                        ?>
                    </td>
                    <td><?php
                            if ($movie->archived_at=== NULL || $movie->showdate === '') {
                                echo $movie->showdate;
                            }else{
                                echo "-";
                                
                            }
                        ?>
                    </td>
                    </td>
                    
                </tr>
                <?php } endforeach; ?>
            </tbody> 
            </table>
        </div>
    </article>
  </main>
  <script type="text/javascript" src="main.js"></script>
  <script>
    AOS.init();    
        var currentUrl = window.location.href;


var links = document.querySelectorAll(".options a");


var activeLink = null;
var activeIndex = -1;

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

  if (activeLink && (event.key === "ArrowUp" || event.key === "ArrowDown")) {

    event.preventDefault();

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