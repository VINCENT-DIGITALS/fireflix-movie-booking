<?php
include 'adminSystem.php';
session_start();
adminSystem::return();

if (isset($_SESSION['ServiceID'])) {
  $ServiceID = $_SESSION['ServiceID'];
  global $connection;
  $sql = "SELECT * FROM services WHERE ServiceID='$ServiceID'";
  $result = $connection->query($sql);

  if ($row = $result->fetch_assoc()) {

    $name = $row['name'];
    $type = $row['type'];
    $price_per_item = $row['price_per_item'];
    $quantity = $row['quantity'];
    $poster =$row['product_img'];
    $description = $row['description'];
  }
}


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
  public function updateserviceData()
  {
    // Connect to the database
    global $connection;
    $sql = "UPDATE services SET name='$this->name', type='$this->type', price_per_item='$this->price_per_item', quantity='$this->quantity', description='$this->description', product_img='$this->poster' WHERE ServiceID='$this->ServiceID'";

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
if (isset($_POST['logout'])) {
  SessionManager::endSession();
}
// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Create a new Movie object

  $service->ServiceID = $_SESSION['ServiceID'];
  $service->name = $_POST['name'];
  $service->type = $_POST['type'];
  $service->price_per_item = $_POST['price_per_item'];
  $service->quantity = $_POST['quantity'];
  $service->description = $_POST['description'];


  // Get the filename and temporary file location
  $filename = $_FILES['poster']['name'];
  $tmpname = $_FILES['poster']['tmp_name'];

  // Move the file to a folder on your server
  $folder = 'products/';
  move_uploaded_file($tmpname, $folder . $filename);

  // Set the picture variable to the filename
  $service->poster = $folder . $filename;

  // Insert the movie data into the database


  $service->updateserviceData();
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
  <title>Add Mvoies Page</title>
  <!-- aos css cdn link  -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <link rel="stylesheet" type="text/css" href="style.css">
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
          <li class="choice"><a href="todayshow.php">Today' Show</a></li>
          <li class="choice"><a href="todaybooking.php">Today's Booking</a></li>
          <li class="choice"><a href="services.php">Services</a>
            <ul>
              <li class="nestedchoice"><a href="addservice.php">Add Services</a></li>
              <li class="nestedchoice"><a href="updatefoods.php">Update Services</a></li>
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
              <input required type="text" name="name" value="<?php echo $name ?>" autofocus></input><br>

              <label>Image:</label>
              <input id="poster" type="file" name="poster" accept="image/*" value="NULL"></input><br>

              <label>Type</label>
              <select required name="type" id="">
                <option value="<?php echo $type ?>"><?php echo $type ?></option>
                <option value="Food">Food</option>
                <option value="Drink">Drink</option>
              </select>


              <label>Price per item:</label>
              <input type="number" name="price_per_item" value="<?php echo $price_per_item ?>"></input><br>


              <label>quantity:</label>
              <input required type="number" name="quantity" value="<?php echo $quantity ?>"></input><br>

            </div>

            <div class="synopsis"><label>Description:</label>
              <textarea class="textarea" type="text" name="description" ><?php echo $description ?></textarea><br>
            </div>

            <input required class="submit" type="submit" name="submit" value="Update"></input>

          </form>
        </div>
        <div class="poster">
            <?php 
              if (isset($poster)) { ?>
                <img id="img" src="<?php echo $poster ?>"  alt="poster" height="300px">
            <?php  }else { ?>
                <img id="img" src="img/choose.png" alt="poster" height="300px">
            <?php  } ?>
          
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