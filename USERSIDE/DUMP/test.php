<?php

use PhpParser\Node\Stmt\Echo_;

include 'connectDB.php';
include_once 'sessionhandler.php';
SessionManager::startSession();

class Movie {
  
    public $MID;
    public $movie_name;
    public $synopsis;
    public $running_time;
    public $price;
    public $discount;
    public $poster;
    public $archived_at;
    public $genre;
    public $trailer;
    public $releasedate;
    public $screen;
    public $showdate;
  
    public static function getAllMovies() {
        global $connection;
        $sql = "SELECT * FROM movies";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
     
            $movies = array();

            while ($row = $result->fetch_assoc()) {
                $movie = new Movie();
                $movie->MID = $row['MID'];
                $movie->movie_name = $row['movie_name'];
                $movie->synopsis = $row['synopsis'];
                $movie->running_time = $row['running_time'];
                $movie->price = $row['price'];
                $movie->discount = $row['discount'];
                $movie->poster = $row['poster'];
                $movie->archived_at = $row['archived_at'];
                $movie->genre = $row['genre'];
                $movie->trailer = $row['trailer'];
                $movie->releasedate = $row['releasedate'];
                $movie->screen = $row['screen'];
                $movie->showdate = $row['showdate'];

                $movies[] = $movie;
            }


            return $movies;
        } else {

    
        }
    }

    
}

$movies = Movie::getAllMovies();



 foreach ($movies as $movie) {
  Echo $movie->  
}
?>