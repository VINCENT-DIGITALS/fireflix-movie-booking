<?php
include '../System/sessionHandler.php';
session_start();
adminSystem::adminReturn();
// Create a class for handling movie data
class Service
{
  // Define properties for movie data
  public $ServiceID;
  public $name;
  public $type;
  public $price_per_item;
  public $quantity;
  public $poster;
  public $description;


  // Define a method for inserting the movie data into the database
  public function insertMovieData()
  {
    // Connect to the database
    global $connection;

    // Insert the movie data into the database
    $sql = "INSERT INTO services (name, type, price_per_item, quantity, description, product_img)
            VALUES ('$this->name', '$this->type', '$this->price_per_item', '$this->quantity', '$this->description', '$this->poster')";

    if ($connection->query($sql) === TRUE) {
      //DO A PROMPT SHOWING, SUCCESFULLY ADDED THE DATA
      echo '<div id="my-panel" class="panel">
      <h2>You have Successfully Added the Product ', $this->name, '!</h2>
      <button class="servicerefresh-btn" id="close-btn">X</button>
      </div>';
    } else {
      echo "Error inserting movie data: " . $connection->error;
    }
    // Close the database connection
    $connection->close();
  }
}


$service = new Service();

// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Create a new Movie object

  // Get the movie data from the form
  $service->name = $_POST['name'];
  $service->type = $_POST['type'];
  $service->price_per_item = $_POST['price_per_item'];
  $service->quantity = $_POST['quantity'];
  $service->description = $_POST['description'];


  // Get the filename and temporary file location
  $filename = $_FILES['poster']['name'];
  $tmpname = $_FILES['poster']['tmp_name'];

  // Move the file to a folder on your server
  $folder = '../images/service_imgs/';
  move_uploaded_file($tmpname, $folder . $filename);

  // Set the picture variable to the filename
  $service->poster = $folder . $filename;

  // Insert the movie data into the database


  $service->insertMovieData();
  // Check if a file was uploaded

}
if (isset($_POST['my_btn'])) {
  header("location:services.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Service Page</title>
  <!-- aos css cdn link  -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

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
          <li class="choice"><a href="todayshow.php">Now Showing</a></li>
          <li class="choice"><a href="todaybooking.php">Booking</a></li>
          <li class="choice"><a href="services.php">Services</a>
            <ul>
              <li class="nestedchoice"><a href="addservice.php">Add Service</a></li>
              <li class="nestedchoice"><a href="updateservice.php">Update Services</a></li>
            </ul>
          </li>
          <li class="choice"><a href="reviews.php">Reviews</a></li>
        </ul>
      </div>
    </aside>
    <article class="content">
      <div class="form">
        <div class="forminput">
          <form method="post" enctype="multipart/form-data">
            <div class="others">
              <label>Name:</label>
              <input required type="text" name="name" autofocus></input><br>

              <label>Image:</label>
              <input id="poster" type="file" name="poster" accept="image/*" value="NULL"></input><br>

              <label>Type</label>
              <select required name="type" id="">
                <option value=""></option>
                <option value="Food">Food</option>
                <option value="Drink">Drink</option>
              </select>


              <label>Price per item:</label>
              <input type="number" name="price_per_item"></input><br>


            </div>

            <div class="synopsis"><label>Description:</label>
              <textarea class="textarea" type="text" name="description"></textarea><br>
            </div>

            <input required class="submit" type="submit" name="submit" value="Add"></input>

          </form>
        </div>
        <div class="poster">
          <img id="img" src="../img/choose.png" alt="poster" height="300px">
        </div>
      </div>
    </article>
  </main>
  <script type="text/javascript" src="../main.js"></script>
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