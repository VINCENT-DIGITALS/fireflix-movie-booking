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

    public static function return()
    {
        if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
            header("Location: Adminlogin.php");
            exit();
        } 
    }

    public static function setlogin($username, $password)
    {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    }

    
    public static function endSession()
    {
        session_unset();
        header("Location: Adminlogin.php");
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
