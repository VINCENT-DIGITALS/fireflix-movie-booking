<?php 
include '../System/sessionHandler.php';
session_start();
adminSystem::adminReturn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Display Booking Page</title>
  <link rel="stylesheet" type="text/css" href="css/style2.css">
  <script type="text/javascript" src="main.js"></script>

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
    <article class="content" style="margin-left: 35%;">
      <div class="display">
        <table>
          <?php

          global $connection;
          $current_date = date('Y-m-d');

        
          $sql = "SELECT booking.BID, booking.seating_num, booking.total_cost,
          DATE_FORMAT(booking.booked_at, '%Y-%m-%d' ) AS booked_at, movies.MID, movies.movie_name, movies.archived_at,
          movies.running_time, movies.poster, DATE_FORMAT(movies.showdate, '%Y-%m-%d') AS showdate,
          user.UID, user.fullname
          FROM booking 
          INNER JOIN movies ON movies.MID = booking.MID 
          INNER JOIN user ON user.UID = booking.UID 
   
          WHERE DATE(booking.booked_at) <= '$current_date'AND DATE(booking.booked_at) >'0000-00-00' AND movies.archived_at IS NULL
          ORDER BY booked_at DESC";
            $result = $connection->query($sql);



          if ($result->num_rows >0) {
          ?>
            <thead>
              <tr>
                <th>No.</th>
                <th>User Name</th>
                <th>Movie Name</th>
                <th>Seating Number</th>
                
                <th>Book Date</th>
                <th>Show Date</th>
                

              </tr>
              <tr></tr>
              <tr></tr>
            </thead>
            <tbody class="action">
              <?php
              $count = 0;
              $current_date = date('Y-m-d');
              while($row = $result->fetch_assoc()) {
                if ($row['booked_at'] <= $current_date && $row['archived_at'] == NULL) {
                  $count++;

              ?>
                  <tr class="movies">
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row['fullname']; ?></td>
                    <td><?php echo $row['movie_name']; ?></td>
                    <td><?php echo $row['seating_num']; ?></td>
                 
                    <td><?php echo $row['booked_at']; ?></td>
                    <td><?php echo $row['showdate']; ?></td>
           
                  </tr>
              <?php }
                } ?>
            </tbody>
          <?php } else { ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td style="font-size: 50px;">No One Booked today</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          <?php  } ?>
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
<?php

if (isset($_POST['my_btn'])) {
  header("location:viewmovieadmin.php");
}
// Get all non-archived movies from the database


?>