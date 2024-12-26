<?php
  
class SessionManager {
    private $username;
    private $password;
    
    public static function startSession() {
       session_start();
    }

    public static function return(){
        if(empty($_SESSION['username']) && empty($_SESSION['password'])) {
            header("Location: userlogin.php");
            exit();
        }
    }

    //USER 
    public static function setUserLogin($UID, $username, $password, $fullname, $email, $contact_num) {
        $_SESSION['UID'] = $UID;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['contact_num'] = $contact_num;


    }
    public static function getUID(){    
       return $_SESSION['UID'];
    
    }
    public static function getUsername(){
        return $_SESSION['username'];
       }

       public static function getPass(){
        return $_SESSION['password'];
        
     }
     public static function getFullname(){
        return $_SESSION['fullname'];
        
     }

     public static function getEmail(){
        return $_SESSION['email'];
     }

     public static function getContactNum(){
         return $_SESSION['contact_num'];
     }

     //BOOKING
    public static function setBooking( $booked_at, $showtime, $total_cost, $movie_name, $seating_num, ){
        if(isset($booked_at)){
            $_SESSION['booked_at'] = $booked_at;
        }
        if(isset($showtime)){
            $_SESSION['showtime'] = $showtime;
        }
        if(isset($total_cost)){
            $_SESSION['cost'] = $total_cost;
        }
        if(isset($movie_name)){
            $_SESSION['movie_name'] = $movie_name;
        }
        if(isset($seating_num)){
            $_SESSION['seating_num'] = $seating_num;
        }

    }

    public static function unsetBooking(){

        unset($_SESSION['booked_at']);
        unset($_SESSION['showtime']);
        unset($_SESSION['cost']);
        unset($_SESSION['movie_name']);
        unset($_SESSION['seating_num']);
    
    }
    public static function getBooked()
    {
        return $_SESSION['showtime'];
    }
    public static function getShowtime()
    {
        return $_SESSION['showtime'] ;
    }
    public static function getCost()
    {
        return $_SESSION['cost'] ;
    }
    public static function getMovieNmae()
    {
        return $_SESSION['movie_name'] ;
    }
    public static function getSeatingNum()
    {
        return $_SESSION['seating_num'] ;
    }
    


    //SERVICES
    public static function setService($name,$type, $price, $quantity, $description, $productImage ){
        if(isset($name)){
            $_SESSION['name'] = $name;
        }
        if(isset($type)){
            $_SESSION['type'] = $type;
        }
        if(isset($price)){
            $_SESSION['price'] = $price;
        }
        if(isset($quantity)){
            $_SESSION['quantity'] = $quantity;
        }
        if(isset($descrition)){
            $_SESSION['descrition'] = $descrition;
        }
        if(isset($productImage)){
            $_SESSION['productImage'] = $productImage;
        }
    }

    public static function getServiceName()
    {
        return $_SESSION['name'] ;
    }
    public static function getServiceType()
    {
        return  $_SESSION['type'] ;
    }
    public static function getServiceprice()
    {
        return $_SESSION['price'] ;
    }

    public static function getServiceQuantity()
    {
        return  $_SESSION['quantity'] ;
    }

    public static function getServiceDescription()
    {
        return $_SESSION['descrition'] ;
    }

    public static function getServiceProductImage()
    {
        return $_SESSION['productImage'] ;
    }

    public static function unsetService( ){
        
        unset($_SESSION['name']);
        unset($_SESSION['type']);
        unset($_SESSION['price']);
        unset($_SESSION['quantity']);
        unset($_SESSION['description']);
        unset($_SESSION['productImage']);
    }

    //USNET ALL
    public static function endSession() {
        session_unset();
        header("Location: userlogin.php");
        exit();
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
/*
    session_start();
       echo $_SESSION['UID'] ,'<br>';
       echo $_SESSION['username'] ,'<br>';
       echo $_SESSION['password'] ,'<br>';
       echo $_SESSION['fullname'],'<br>';
       echo $_SESSION['email'] ,'<br>';
       echo $_SESSION['contact_num'],'<br>';
*/
