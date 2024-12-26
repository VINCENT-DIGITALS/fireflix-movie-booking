<?php

include '../System/sessionHandler.php';
    include 'mailing.php';


$show = 0;
if (isset($_POST['return'])) {

    adminSystem::unsetBooking();
    header('location:home.php');
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Food and Drinks | FireFlix</title>
    <link rel="stylesheet" href="CSS/stylesheet.css">
    <script src="https://kit.fontawesome.com/92d70a2fd8.js" crossorigin="anonymous"></script>
</head>
<style>
    .success{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .success p{
        text-align: center;
    }
    .success p a{
        color: red;
        text-decoration: none;
    }

</style>
<body>
    <div class="header">
        <p class="logo">FOOD AND DRINKS</P>
        <form method="post"><button class="return" id="return" name="return">Return</button></form>
    </div>
    <?php 
        if ($show ==1) {
           echo'<div class="success"><p>Booking Sucess<br><a href="https://mail.google.com/mail/u/1/#inbox">Your Ticket has been delivered to you Email</a></p></div><br>'; 
        }
    ?>
    
    <div class="container">
        <div id="root"></div>
        <div class="sidebar">
            <div class="head">
                <div class="cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <p id="count">0</p>
                </div>
                <p> &nbsp; My Selection</p>
            </div>
            <div id="cartItem">No food/drinks selected.</div>

            <br>
            <form method="post" action="payment.php">
            <input type="hidden" name="total" value="<?php  $total = $_COOKIE['passed_total'];
            echo $total;?>">    
            <button name="submit">Next</button></form>
            <div class="foot">
                <h3>Total</h3>
                <h2 id="total">PHP 0.00</h2>
            </div>
        </div>
    </div>
    <script src="js/items.js">    </script>
</body>

</html>