<?php
 session_start();
use Hamcrest\Arrays\IsArray;
if (isset($_POST['total'])) 
{
    $_SESSION['total'] =  $_POST['total'];
  
}
$costofservice =     $_SESSION['total'] ;
$show = 0;
include 'mailing.php';

try {
    //server with default setting (user 'root' with no password)
    $host = 'localhost';  // server 
    $user = 'root';
    $pass = "";
    $database = 'fireflixdb';   //Database Name  
    $connection = new mysqli($host, $user, $pass, $database);
  
} catch (Exception $e) {
    echo "Error connecting to database: " . $e->getMessage();
}

$MID = $_SESSION['MID'];
$sql = $connection->query("SELECT price, discount FROM movies WHERE MID='$MID'");
if ($sql->num_rows > 0) {
    while ($row = $sql->fetch_assoc()) {
        $price = $row['price'];
        $discount = $row['discount'];
    }
}


if (isset($_POST['confirm'])) {
 
        $show = mailingSystem::bookingConfirm();  
}

if (isset($_POST['home'])) {
    header('location:home.php');
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/payments.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <title> Booking Summary </title>

</head>

<body>



    <div class="container">
        <!-- -->
        <div class="py-5">
            <div class="row p-5">
                <div class="col-md-12 mb-5 my-5">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="booking">Booking Summary</h1>
                    </h4>
                    <ul class="list-group mb-3 sticky-top">
                        <li class="list-group-item d-flex justify-content-between">
                            <table id="table" class="table table-dark table-hover">
                                <tr class="text-danger table-secondary ">
                                    <th>
                                        <h4>Services</h4>
                                    </th>
                                    <th>
                                        <h4>Cost of services</h4>
                                    </th>
                                    <th>
                                        <h4>Seats</h4>
                                    </th>
                                    <th>
                                        <h4>Cost of movies</h4>
                                    </th>
                                    <th>
                                        <h4>Discount per movie</h4>
                                    </th>


                                </tr>
                                <tr class="text-center" style=" font-size:2rem;">
                                    <td id=name>Food/Drinks</td>
                                    <td id=name><?php echo $costofservice; ?></td>
                                    <td id=quantity><?php
                                                    $count = 0;
                                                    $seats = $_SESSION['seating_num'];
                                                    foreach ($seats as $seat) {
                                                        echo $seat, '  ';
                                                        $count++;
                                                    }
                                                    ?></td>
                                    <td id=price><?php echo $price = $price * $count; ?></td>
                                    <td id=discount><?php echo $discount,'%'; ?></td>


                                </tr>
                            </table>
                            <div id="finalproducts"></div>
                        </li>
                    </ul>
                    <ul class="list-group mb-3 sticky-top">
                        <li class="list-group-item d-flex justify-content-between">
                            <h4 class="m-5" style="color:red; font-size:3rem;"> Total Payment: <?php
                                                            $discounted  = $price * ($discount / 100);
                                                            $totalpayment = $costofservice + $price - $discounted;
                                                            echo $totalpayment; ?> </h4>
                            <h1 class="text-danger" id="total"></h1>
                        </li>
                    </ul>
                </div>
                <div class="col justify-content-center">
                    <h4 class="mb-3">PERSONAL DETAILS</h4>
                    <form method="post" class="needs-validation" novalidate="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">Fullname</label>
                                <input disabled type="text" class="form-control" id="firstName" placeholder="<?php echo $_SESSION['fullname']; ?>" value="" required="">
                                <div class="invalid-feedback"> Valid first name is required. </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="username">Username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input disabled type="text" class="form-control" id="username" placeholder="<?php echo $_SESSION['username']; ?>" required="">
                                <div class="invalid-feedback" style="width: 100%;"> Your username is required. </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email <span class="text-muted"></span></label>
                            <input disabled type="email" class="form-control" id="email" placeholder="<?php echo $_SESSION['email']; ?>" required>
                            <div class="invalid-feedback"> Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address2">Phone <span class="text-muted"></span></label>
                            <input disabled type="text" class="form-control" id="address2" placeholder="<?php echo $_SESSION['contact_num']; ?>" required>
                        </div>


                        <hr class="mb-4">
                        <h4 class="mb-3">PAYMENT METHOD</h4>
                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                                <label class="custom-control-label" for="credit"> GCASH </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                                <label class="custom-control-label" for="credit">DEBIT/CREDIT</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                                <label class="custom-control-label" for="credit">PAYMAYA</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc-name">Name on card</label>
                                <input  type="text" class="form-control" id="cc-name" placeholder="" required>
                                <small class="text-muted">Full name as displayed on card or Account Name</small>
                                <div class="invalid-feedback"> Name on card is required </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc-number">Credit card number</label>
                                <input type="text" class="form-control" id="cc-number" placeholder="" required >
                                <small class="text-muted">GCASH or PAYMAYA Number</small>
                                <div class="invalid-feedback"> Credit card number is required </div>
                            </div>
                        </div>

                        <hr class="mb-5">
                        <?php //hide
                        if ($show == 1) {
                            # code...
                        
                            echo '<p disbabled id="btn" class="btn-block btn btn-info btn-lg" type="submit" data-toggle="modal" data-target="#myModal" style="background-color: darkred;">
                            Payment Successful</p>';                            
                            echo '<button name="home" id="btn" class="btn-block btn btn-info btn-lg" type="submit" data-toggle="modal" data-target="#myModal" style="background-color: darkred;">
                            HOME</button>';
                        }     
                        
                        else { ?>
                        <div class="d-flex justify-content-center">
                            <button name="confirm" id="btn" class="btn-block btn btn-info btn-lg" type="submit" data-toggle="modal" data-target="#myModal" style="background-color: darkred;">
                                Confirm Payment</button>

                          <?php      }  ?> 
                        </div>
                    </form>
                </div>
            </div>

        </div>


        <script src="js/payment.js"></script>

</body>

</html>