<?php 
include '../System/sessionHandler.php';
session_start();
   
    // Get the session variables
    $cname = $_SESSION['fullname'];
    $seat = $_SESSION['seating_num'];
    $showdate = $_SESSION['showtime'];
    $movie = $_SESSION['movie_name'];
    

    
    require __DIR__ . '/vendor/autoload.php';

    use Picqer\Barcode\BarcodeGeneratorPNG;
    
foreach ($seat as $seat) {
    # code...

    $generator = new BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($seat, $generator::TYPE_CODE_128);
    
}    


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Ticket Design</title>
	<style>
        
		body {
			font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: transparent;
        background-image: none;
            width: 100%;

		}
		.ticket {

			padding: 10px;
			width: 400px;
			height: max-content;
            margin: 0 auto;

			text-align: center;
            display: flex;
            border-radius: 2%;
            flex-direction: column;

		}
        .topleft{
          
           
            width: 100%;
            background-color: aqua;
       
            display: flex;
            flex-direction: column;
                
  
        }

  
        .rightside{
          
            width: 100%;
            background-color: ivory;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            
        }

        
        .showside{
          margin-left: 2%;
          margin-top: 8%;
            font-size: 10px;
         }
      .movieside{
            display:flex;
            flex-direction: column;
            max-width: 50%;
            margin-top: 5% ;
            margin-left: 2%;
            word-wrap: break-word;
            

        }
      
        .moviename{
            margin-bottom: -5px;
            margin-left: 2%;
            max-width: 100%;
            font-size: 1rem;
            text-size-adjust: 100%;
        }
   
        .hrline{
            width: 50%;
        }
        .brcode img{
            
            height: 26px;
            width: 50%;
            
        }
  
         .topleft div img{
            width: 10%;
            
            float: left;
            margin-left: 5%;
            margin-top: 2%;

        }
     
        .seat{
            margin-top: 5%;
            margin-bottom: 8%;
            
        }
        .name{
            margin-top: 2%;
            margin-bottom: 2%;
        }
  
	</style>
</head>
<body>
	<div class="ticket">
            <div class="top">
                <div class="topleft">
                    <div class="name"><img src="../img/FireFlix Logo (No Background).png"  width="70px" height="70px" alt="logo" style="float: left; margin-left: 5%; ">
                </div>
                    
                </div>
            
            </div>
           <div class="content">
           <div class="rightside">
                <div class="movieside"><?php
                    echo '<h3 class="moviename">',$movie,'</h3>
                            <hr class="hrline"></hr>
                            Movie';
                    ?>
                
                </div>
                
                <div class="showside">
                    <?php 
                        echo '<h3 class="moviename">',$showdate,'</h3>
                        <hr class="hrline"></hr>
                        Show date';
                    ?>
                </div>
                <div class="seat">
                    <?php 
                    $seat = $_SESSION['seating_num'];
                    foreach($seat as $seat){
                        echo '<h3 class="moviename">',$seat,'</h3>';
                    }
                       echo '<hr class="hrline"></hr>
                        SEAT';
                    ?>
                    <div class="brcode">
                        <?php echo '<img src="data:image/png;base64,' . base64_encode($barcode) . '">'; 
                        ?>
                    </div>
                </div>
            </div>


           </div>
	
	</div>
</body>
</html>
