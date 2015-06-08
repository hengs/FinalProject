<?php

//include"creds.php";
session_start();
if(!$_SESSION["Username"]){
	echo "You are not logged in!";
	header("location: login.php");
	echo '<br/>Please <a href="index.php" class="btn btn-primary btn-lg active" role="button">Login</a>';
	die();
}


?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Restaurant Hub Home Page</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		
		<link href="css/styles.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>


	</head>
	<body style = "background-color:#F0F8FF">

<header class="navbar navbar-default navbar-static-top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="videos.php" class="navbar-brand">Home</a>
    </div>
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="videos.php">Back to Your Restaurant Home Page</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="index2.php">About</a>
                    </li>
                    <li>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
  </div>
</header>

<div class="col-md-3" id="leftCol">
                
        <div class="well"> 
                
          </div>

          </div>  

<div class="container"><font size = "4">
	<div class="row">
  			
      		<div class="col-md-9">
			<?php
			
              	echo "<h1>Welcome ".$_SESSION['Username']." to Restaurant Hub</h2><hr>";
              ?>
              	<h2>About Restaurant Hub</h2>
              	<p>
                Hi, welcome to my site called Restaurant Hub. In case you didn't know, Restaurant Hub is 
               place where people can write and view restaurant reviews with the community. 
			   You can save your favorite restaurants for future use, search for new ones, and post your own personal reviews for the community to see. <br/>

              	</p><hr>
                <p>
                  <div class="row">
                  <div class="col-md-12"><img src="restaurant.jpg" class="img-responsive"></div>
                    
                </div>

                </p>
              
              	<hr>
              
              	<h2>Lets Get Started</h2>
              	<p>
                To view your Restaurant Hub community site. Please click below.
				<a href="videos.php" class="btn btn-primary btn-lg active" role="button">Hub Site</a>
					
              	<hr>
              <h4><br/>Design with help from <a href="http://getbootstrap.com">Bootstrap</a></h4>
              	<hr>
              	
              	
      		</div> 
  	</div>
</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>