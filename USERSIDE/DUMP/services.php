<?php

use PhpMyAdmin\SqlParser\Utils\Query;

include 'adminSystem.php';
session_start();
adminSystem::return();
// Define a class for handling movie data
class Service {
    // Define properties for movie data
    public $ServiceID;
    public $name;
    public $type;
    public $price_per_item;
    public $quantity;
    public $description;
    public $archived_at;
    public $poster;

    public static function getAllServices() {
        global $connection;
        $sql = "SELECT * FROM services";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            // Create an array to hold the movies
            $services = array();

            // Loop through each row and create a Movie object for each movie
            while ($row = $result->fetch_assoc()) {
                $service = new Service();
                $service->ServiceID =$row['ServiceID']; 
                $service->name = $row['name'];
                $service->type = $row['type'];
                $service->price_per_item = $row['price_per_item'];
                $service->quantity = $row['quantity'];
                $service->description = $row['description'];
                $service->archived_at=$row['archived_at'];
                $service->poster=$row['product_img'];
                // Add the Movie object to the movies array
                $services[] = $service;
            }

            // Return the movies array
            return $services;
        } else {
            // Return an empty array if there are no movies
            return array();
        }
    }

    // Define a method for archiving a movie in the database
    public static function archiveService($ServiceID, $name, $type) {
        global $connection;
        $sql = "UPDATE services SET archived_at=NOW() WHERE ServiceID='$ServiceID'";
       if ($connection->query($sql) === TRUE) {
        //DO A PROMPT
        echo '<div id="my-panel" class="panel">
        <h2>You have Successfully Archived the ',$type,', ',$name,' !</h2>
        <Form method="POST"><button class="refresh-btn" type="submit" name="my_btn" id="close-btn">X</button></form>
        </div>';
        

      } else {
        echo "Failed to Archive movie data: " . $connection->error;
      }
    }
    public static function unarchiveService($ServiceID,$name, $type) {
      global $connection;
      $sql = "UPDATE services SET archived_at=NULL WHERE ServiceID=$ServiceID";
      
      if ($connection->query($sql) === TRUE) {
        //DO A PROMPT 
        echo '<div id="my-panel" class="panel">
              <h2>You have Successfully Unarchive the ',$type,', ',$name, '!</h2>
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
    $ServiceID = $_POST['ServiceID'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    Service::archiveService($ServiceID,$name, $type);
}
if (isset($_POST['unarchive'])) {
  $ServiceID = $_POST['ServiceID'];
  $name = $_POST['name'];
  $type = $_POST['type'];
  Service::unarchiveService($ServiceID,$name, $type);
}
if (isset($_POST['update'])) {
  $_SESSION['ServiceID'] = $ServiceID = $_POST['ServiceID'];
   
  header('location:updateservicepage.php');
}
if (isset($_POST['my_btn'])) {
  header("location:updatefoods.php");
}

$services = Service::getAllServices();

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
              <ul>
                <li class="nestedchoice" data-aos="fade-right"  data-aos-easing="linear" data-aos-duration="500"><a href="addservice.php">Add Service</a></li>
                <li class="nestedchoice" data-aos="fade-right"  data-aos-easing="linear" data-aos-duration="500"><a href="updatefoods.php">Update Services</a></li>
              </ul>

          </li>
          <li class="choice"><a href="reviews.php">Reviews</a></li>


        </ul>
      </div>
    </aside>
    <article class="content">
        <div class="display">
            <table class="viewtable" >
            <thead>
                <tr><th>Service ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price per Item</th>
                    <th>quantity</th>
                    <th>Product Image</th>
                </tr>
            </thead>  
            <tbody class="action">
                <?php foreach ($services as $service): 
                  if ($service->archived_at=== NULL) {?>
                  
                <tr class="movies">
                    <td><?php echo $service->ServiceID; ?></td>
                    <td><?php echo $service->name; ?></td>
                    <td class="long-text"><?php echo $service->type; ?></td>
                    <td><?php echo $service->price_per_item; ?></td>
                    <td><?php echo $service->quantity; ?></td>
                    <td><?php 
                        if ($service->poster === '') { // or !(substr($service->product_img, 0, 5)) == 'posters/'
                            echo "-";
                        }else{
                          
                            echo '<img class="display-poster" src="',$service->poster,'" alt="poster" >';
                        }
                        ?></td>
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
    links[i].style.fontSize = "1.6em";

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