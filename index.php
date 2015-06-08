<?php

//include"creds.php";

include "loginfo.php"; // Includes Login Script

if(isset($_SESSION['Username'])){
header("location: videos.php");
}

include"creds.php";



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
		
		<script>


function showCreate(str) {
    if (str == "") {
        document.getElementById("txtHints").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHints").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","check_username.php?q="+str,true);
        xmlhttp.send();
    }
}

</script>
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
      <a href="index.php" class="navbar-brand">Home</a>
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
                <a class="navbar-brand topnav" href="index.php">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="index.php">Sign Up</a>
                    </li>
                    <li>
                        <a href="index.php">Login</a>
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
                <h1>Login</h1><br/>
	
				<form method = "POST" action="">
					Username: <input type="text" name="usernames" required><br/><br/>
					Password:  <input type="password" name="passwords" required><br/><br/>
					<input type="submit" class="btn btn-primary btn-lg active" name="login" value="Log In"><br/>
				</form>


<br/><h2>Create Account</h2><br/>

<form method = "POST" action="">
		
		Username: <input type="text" name="username" onkeyup="showCreate(this.value)" required><br/>
		<span id= "txtHints" class="txtHints"></span><br/>
		Password:  <input type="password" name="password" required><br/><br/>
		Email:     <input type="text" name="email" required><br/><br/>
		
		<input type="submit" name="create" class="btn btn-primary btn-lg active" value="Create Account"><br/>
	</form>
	
          </div>

          </div>  

<div class="container"><font size = "4">
	<div class="row">
  			
      		<div class="col-md-9">
              	<h1>Welcome to Restaurant Hub</h2><hr>
              
              	<h2>About Restaurant Hub</h2>
              	<p>
                Hi, welcome to my site called Restaurant Hub. In case you didn't know, Restaurant Hub is 
               place where people can write and view restaurant reviews with the community. 
			   You can save your favorite restaurants to your favorite list and eat there in the future, or search for new ones that people/friends have added, 
			   and post/edit your own personal reviews for the community to see. Restaurant Hub is a great place to stay connected and enjoy a delicious meal.<br/>

              	</p><hr>
                <p>
                  <div class="row">
                  <div class="col-md-12"><img src="restaurant.jpg" class="img-responsive"></div>
                    
                </div>

                </p>
              
              	<hr>
              
              	<h2>Lets Get Started</h2>
              	<p>
                First you must be either logged in or sign up to view Restaurant Hub's community reviews. Please sign in or create an account on the right index.
				
					
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

<?php


		if(isset($_POST['create'])){
			$signUsers = "SELECT Username FROM Login WHERE Username='$_POST[username]'";
			$check=$con->query($signUsers);
			
			if($check->num_rows>0){
				echo '<script>
				 
					alert("Username already exists. Please try again!");
		
					</script>';
			}
			else if((strlen($_POST['username'])<4) || (strlen($_POST['password'])<4)){
				echo '<script>
				 
					alert("Username and/or password is too short. Each must be 4 characters long!");
		
					</script>';
				
			}
			else{
				
				$AddQuery = $con->prepare ("INSERT INTO Login (Username, Password, Email) VALUES ('$_POST[username]','$_POST[password]','$_POST[email]')");         
				echo '<script>
				 
					alert("New Account Created Successfully! Please Log in.");
		
					</script>';
				$AddQuery->execute();
				$AddQuery->close();
				}
				$check->close();
		};
	
	
	?>