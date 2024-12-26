<?php

use PhpMyAdmin\SqlParser\Utils\Query;

include 'adminSystem.php';
session_start();
adminSystem::return();
// Define a class for handling movie data
class Review {
    // Define properties for movie data
    public $UID;
    public $RID;
    public $fullname;
    public $review;
    public $time;
    public $approved_at;

    public static function getAllReviews() {
        global $connection;
        $sql = "SELECT user.UID, user.fullname, reviews.RID, reviews.review, reviews.time,reviews.approved_at
        FROM reviews
        INNER JOIN user 
        ON  reviews.UID=user.UID";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            // Create an array to hold the movies
            $services = array();

            // Loop through each row and create a Movie object for each movie
            while ($row = $result->fetch_assoc()) {
                $Review = new Review();
                $Review->UID =$row['UID']; 
                $Review->RID =$row['RID']; 
                $Review->fullname = $row['fullname'];
                $Review->review = $row['review'];
                $Review->time = $row['time'];
                $Review->approved_at=$row['approved_at'];
                // Add the Movie object to the movies array
                $Reviews[] = $Review;
            }

            // Return the movies array
            return $Reviews;
        } else {
            // Return an empty array if there are no movies
            return array();
        }
    }

    // Define a method for archiving a movie in the database
    public static function approveReview($RID, $fullname,) {
        global $connection;
        $sql = "UPDATE reviews SET approved_at=NOW() WHERE RID='$RID'";
       if ($connection->query($sql) === TRUE) {
        //DO A PROMPT
        echo '<div id="my-panel" class="panel">
        <h2>You have Accepted the review of, ',$fullname,' !</h2>
        <Form method="POST"><button class="servicerefresh-btn" type="submit" name="my_btn" id="close-btn">X</button></form>
        </div>';
        

      } else {
        echo "Failed to Archive movie data: " . $connection->error;
      }
    }
    public static function rejectReview($RID,$fullname) {
      global $connection;
      $sql = "UPDATE reviews SET approved_at=NULL WHERE RID=$RID";
      
      if ($connection->query($sql) === TRUE) {
        //DO A PROMPT 
        echo '<div id="my-panel" class="panel">
              <h2>You Archived the review of ',$fullname, '!</h2>
              <Form method="POST"><button class="servicerefresh-btn" type="submit" name="my_btn" id="close-btn">X</button></form>
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
if (isset($_POST['approved_at'])) {
    $RID = $_POST['RID'];
    $fullname = $_POST['fullname'];
    Review::approveReview($RID,$fullname);
}
if (isset($_POST['rejectreview'])) {
  $RID = $_POST['RID'];
  $fullname = $_POST['fullname'];
  Review::rejectReview($RID,$fullname);
}

if (isset($_POST['my_btn'])) {
  header("location:reviews.php");
}

$Reviews = Review::getAllReviews();

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
        <li class="choice"><a href="dashboard.php">Home</a></li>
         
          <li class="choice"><a href="todayshow.php">Today's Show</a></li>
          <li class="choice"><a href="todaybooking.php">Today's Booking</a></li>
          <li class="choice"><a href="services.php">Services</a>
          </li>
          <li class="choice"><a href="reviews.php">Reviews</a></li>


        </ul>
      </div>
    </aside>
    <article class="content">
        <div class="display">
            <table class="viewtable" >
            <thead>
                <tr><th>Review ID</th>
                    <th>Name</th>
                    <th>Review</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>  
            <tbody class="action">
                <?php foreach ($Reviews as $Review): ?>
                <tr class="movies">
                    <td><?php echo $Review->RID; ?></td>
                    <td><?php echo $Review->fullname; ?></td>
                    <td class="long-text"><?php echo $Review->review; ?></td>
                    <td><?php echo $Review->time; ?></td>
                    <td >
                    <form method="post" action="">
                        <input type="hidden" name="RID" value="<?php echo $Review->RID; ?>">
                        <input type="hidden" name="fullname" value="<?php echo $Review->fullname; ?>">
                        
                        <?php 
                          if ($Review->approved_at=== NULL) {
                          echo '<input class="archive_btn" type="submit" name="approved_at" value="Approve">';
                          }else{
                          echo '<input class="archive_btn" type="submit" name="rejectreview" value="Archive">';
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
