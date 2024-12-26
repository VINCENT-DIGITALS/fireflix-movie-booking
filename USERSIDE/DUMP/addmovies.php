<?php
include 'adminSystem.php';
session_start();
adminSystem::return();

class Movie {

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


  public function insertMovieData() {
    // Connect to the database
    global $connection;

    // Insert the movie data into the database
    $sql = "INSERT INTO movies (movie_name, synopsis, running_time, price, discount, poster, genre, releasedate, trailer, showdate)
            VALUES ('$this->movie_name', '$this->synopsis', '$this->running_time', '$this->price', '$this->discount', '$this->poster', '$this->genre','$this->releasedate', '$this->trailer', '$this->showdate')";

    if ($connection->query($sql) === TRUE) {
      //DO A PROMPT SHOWING, SUCCESFULLY ADDED THE DATA
      echo '<div id="my-panel" class="panel">
      <h2>You have Successfully Added the Movie, ', $this->movie_name,'!</h2>
      <button class="refresh-btn" id="close-btn">X</button>
      </div>';
      
    } else {
      echo "Error inserting movie data: " . $connection->error;
    }
    // Close the database connection
    $connection->close();
  }
}


  $movie = new Movie();
  if (isset($_POST['logout'])) {
    adminSystem::endSession();
  }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the movie data from the form
  $movie->movie_name = $_POST['movie_name'];
  $movie->synopsis = $_POST['synopsis'];
  $movie->running_time = $_POST['running_time'];
  $movie->price = $_POST['price'];
  $movie->discount = $_POST['discount'];
  $movie->genre = $_POST['genre'];
  $movie->trailer = $_POST['trailer'];
  $movie->releasedate =$_POST['releasedate'];
  $movie->showdate = $_POST['showdate'];

    // Get the filename and temporary file location
    $filename = $_FILES['poster']['name'];
    $tmpname = $_FILES['poster']['tmp_name'];

    // Move the file to a folder on your server
    $folder = 'posters/';
    move_uploaded_file($tmpname, $folder.$filename);

    // Set the picture variable to the filename
    $movie->poster = $folder.$filename;



  
  $movie->insertMovieData();


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Mvoies Page</title>
  <link rel="stylesheet" type="text/css" href="style.css">
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
              <li class="nestedchoice"><a href="addmovies.php">Add Movie</a></li>
              <li class="nestedchoice"><a href="updatemovies.php">Update Movies</a></li>
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
        <div class="form">
          <div class="forminput">
            <form method="post"enctype="multipart/form-data">
              <div class="others">
                <label>Movie Name:</label>
                <input required  type="text" name="movie_name" autofocus></input><br>

                <label>Poster:</label>
                <input required  id="poster" type="file" name="poster" accept="image/*"></input><br>

                <label>running_time (in minutes):</label>
                <input required  type="number" name="running_time"></input><br>

                <label>Genre:</label>
                <input  type="text" name="genre"></input><br>

                <label>Trailer:</label>
                <input required  id="trailer" type="text" name="trailer"></input><br>

                <label>Price:</label>
                <input required  type="number" name="price"></input><br>

                <label>Discount:</label>
                <input required type="number" name="discount"></input><br>

                <label>Release Date:</label>
                <input type="date" name="releasedate"></input><br>

                <label>Show Date:</label>
                <input type="date" name="showdate"></input><br>
              </div>

              <div class="synopsis"><label>Synopsis:</label>
                <textarea required  class="textarea" type="text" name="synopsis"></textarea><br>
              </div>

              <input required class="submit" type="submit" name="submit" value="Add"></input>
            
            </form>
          </div>
          <div class="poster"> 
              <img id="img" src="img/choose.png" alt="poster" height="300px">
          </div>
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
