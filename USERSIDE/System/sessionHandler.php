<?php

use PhpParser\Node\Stmt\Static_;

try {
    //server with default setting (user 'root' with no password)
    $host = 'localhost';  // server 
    $user = 'root';
    $pass = "";
    $database = 'fireflix';   //Database Name  
    $connection = new mysqli($host, $user, $pass, $database);
  
} catch (Exception $e) {
    echo "Error connecting to database: " . $e->getMessage();
}

class adminSystem
{


    public function __destruct()
    {
    }

    public static function adminReturn()
    {
        if (empty($_SESSION['adminname']) && empty($_SESSION['adminpassword'])) {
            header("Location: Adminlogin.php");
            exit();
        }
    }
    public static function setAdmdminlogin($username, $password)
    {
        $_SESSION['adminname'] = $username;
        $_SESSION['adminpassword'] = $password;
    }
    public static function endAdminSession()
    {
        unset($_SESSION['adminname']);
        unset($_SESSION['adminpassword']);
        header("Location: Adminlogin.php");
        exit();
    }



    public static function UserReturn()
    {
        if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
            header("Location: userlogin.php");
            exit();
        }
    }
    public static function setUserLogin($UID, $username, $password, $fullname, $email, $contact_num)
    {
        $_SESSION['UID'] = $UID;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['contact_num'] = $contact_num;
    }
    public static function endUserSession()
    {
        unset($_SESSION['UID']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['fullname']);
        unset($_SESSION['email']);
        unset($_SESSION['contact_num']);
        header("Location: userlogin.php");
        exit();
    }






    //BOOKING
    public static function setBooking($MID, $showtime,$movie_name, $seating_num, )
    {
            
            $_SESSION['MID'] = $MID;    
            $_SESSION['showtime'] = $showtime;
            $_SESSION['movie_name'] = $movie_name;
            $_SESSION['seating_num'] = $seating_num;
    }
    public static function setTotal($total_cost){
        $_SESSION['total_cost'] = $total_cost;  
    }

    public static function unsetBooking()
    {

        unset($_SESSION['booked_at']);
        unset($_SESSION['showtime']);
        unset($_SESSION['cost']);
        unset($_SESSION['movie_name']);
        unset($_SESSION['seating_num']);
    }
    //SERVICES
    public static function setService($name, $type, $price, $quantity, $description, $productImage)
    {
        if (isset($name)) {
            $_SESSION['name'] = $name;
        }
        if (isset($type)) {
            $_SESSION['type'] = $type;
        }
        if (isset($price)) {
            $_SESSION['price'] = $price;
        }
        if (isset($quantity)) {
            $_SESSION['quantity'] = $quantity;
        }
        if (isset($descrition)) {
            $_SESSION['descrition'] = $descrition;
        }
        if (isset($productImage)) {
            $_SESSION['productImage'] = $productImage;
        }
    }
    public static function unsetService()
    {

        unset($_SESSION['name']);
        unset($_SESSION['type']);
        unset($_SESSION['price']);
        unset($_SESSION['quantity']);
        unset($_SESSION['description']);
        unset($_SESSION['productImage']);
    }

    public static function setTemp($tempname, $tempID, $tempemail, $tempmessage){
        $_SESSION['fname'] = $tempname;
        $_SESSION['MessageID'] = $tempID;
        $_SESSION['email'] =  $tempemail;
        $_SESSION['message'] = $tempmessage;
    }



    //$username = SessionManager::getSessionVariable('username');
    //$password = SessionManager::getSessionVariable('password');
    /*<?php 
            SessionManager::startSession();
            $username = SessionManager::getSessionVariable('username');
                echo 'Username: ' . $username;
            echo '<br>';
            $password = SessionManager::getSessionVariable('password');
            echo 'Password: ' . $password;
            SessionManager::endSession();
        ?>
     */
}
