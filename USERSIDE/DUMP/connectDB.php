<?php

//server with default setting (user 'root' with no password)
  $host = 'localhost';  // server 
  $user = 'root';   
  $pass = "";   
  $database = 'fireflix';   //Database Name  
  $connection = new mysqli($host,$user,$pass,$database);   

    if ($connection->connect_error) {
        die("Connection Failed! " . $connection->connect_error);
    }else{
    }

?>

