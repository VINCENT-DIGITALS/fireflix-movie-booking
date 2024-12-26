<?php
include '../System/sessionHandler.php';
session_start();
adminSystem::adminReturn();

class Message
{
  // Define properties for movie data
  public $UID;
  public $MessageID;
  public $fullname;
  public $message;
  public $time;
  public $recieved_at;
  public $email;
  public $replied_at;

  public static function getAllMessage()
  {
    global $connection;
    $sql = "SELECT *  FROM messages
        INNER JOIN user 
        ON  messages.UID=user.UID ORDER BY replied_at IS NOT NULL, replied_at DESC";

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {

      // Loop through each row and create a Movie object for each movie
      while ($row = $result->fetch_assoc()) {
        $message = new Message();
        $message->MessageID = $row['MessageID'];
        $message->UID = $row['UID'];
        $message->fullname = $row['fullname'];
        $message->email = $row['email'];
        $message->message = $row['message'];

        $message->recieved_at = $row['recieved_at'];
        $message->replied_at = $row['replied_at'];
        // Add the Movie object to the movies array
        $messages[] = $message;
      }

      // Return the movies array
      return $messages;
    } else {
      // Return an empty array if there are no movies
      return array();
    }
  }


}

if (isset($_POST['replaybtn'])) {
  $name = $_POST['fullname'];
  $MessageID = $_POST['MessageID'];
  $email = $_POST['email'];
  $message= $_POST['message'];

  adminSystem::setTemp($name, $MessageID, $email, $message);
  header('location: replyMessage.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages Page</title>
  <link rel="stylesheet" type="text/css" href="css/style2.css">
  <!-- aos css cdn link  -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

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
          </li>
          <li class="choice"><a href="reviews.php">Reviews</a></li>


        </ul>
      </div>
    </aside>
    <article class="content" style="margin-left: 30%;">
      <div class="display">
        <table class="viewtable">
          <thead>
            <tr>

              <th>Name</th>
              <th>Message</th>
              <th>Recived At</th>
              <th>Replied At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="action">
            <?php
              

          $messages = Message::getAllMessage();
            foreach ($messages as $message) : ?>
              <tr class="movies">

                <td><?php echo $message->fullname; ?></td>
                <td class="long-text"><?php echo $message->message; ?></td>
                <td><?php echo $message->recieved_at; ?></td>
                <td>
                  <?php if (!is_null($message->replied_at)) {
                    echo $message->replied_at;
                  } else {
                    echo '-';
                  }
                  ?>
                </td>

                <td>
                  <form method="post" >
                    <input type="hidden" name="MessageID" value="<?php echo $message->MessageID; ?>">
                    <input type="hidden" name="fullname" value="<?php echo $message->fullname; ?>">
                    <input type="hidden" name="email" value="<?php echo $message->email; ?>">
                    <input type="hidden" name="message" value="<?php echo $message->message; ?>">

                    <?php
                    if ($message->replied_at === NULL) {
                      echo '<input class="archive_btn" type="submit" name="replaybtn" value="Reply">';
                    } else {
                      echo '<input class="archive_btn" type="submit" name="replied" value="Replied" disabled>';
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
  <script type="text/javascript" src="js/main.js"></script>
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