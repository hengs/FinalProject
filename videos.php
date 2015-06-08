<?php

session_start();

if(!$_SESSION["Username"]){
	echo "You are not logged in!";
	header("location: login.php");
	echo '<br/>Please <a href="index.php" class="btn btn-primary btn-lg active" role="button">Login</a>';
	die();
}

include "creds.php";






if(isset($_POST['checkout'])){
	$UpdateQuery = $con->prepare("UPDATE MyRestaurants SET Recommend = 1  WHERE id ='$_POST[checkout]'");               
	$UpdateQuery->execute();
	$UpdateQuery->close();
	echo "Movie has now been checked out.<br/>";
};

if(isset($_POST['checkin'])){
	$UpdateQuery1 = $con->prepare("UPDATE MyRestaurants SET Recommend = 0  WHERE id ='$_POST[checkin]'");               
	$UpdateQuery1->execute();
	$UpdateQuery1->close();
	echo "Restaurant has now been checked in.<br/>";
};
echo $_SESSION['Username']."'s Restaurant Reveiw Lists";

if(isset($_POST['edit'])) {
	
	if((isset($_POST['rec']))!=NULL && (isset($_POST['types']))!=NULL  && (isset($_POST['rates']))!=NULL && (isset($_POST['restN']))!=NULL){
		
	$EditQuery = $con->prepare("UPDATE MyRestaurants SET RestName = '$_POST[restN]', FoodType ='$_POST[types]', Rating='$_POST[rates]', Recommend='$_POST[rec]' WHERE id = '$_POST[edit]' ");
	$EditQuery->execute();
	$EditQuery->close();
	//echo "You have edited your Restaurant Review <br/>";
	}
	else if((isset($_POST['types']))!=NULL  && (isset($_POST['rates']))!=NULL && (isset($_POST['restN']))!=NULL)
	{

	$EditQuery = $con->prepare("UPDATE MyRestaurants SET RestName = '$_POST[restN]', FoodType ='$_POST[types]', Rating='$_POST[rates]' WHERE id = '$_POST[edit]' ");
	$EditQuery->execute();
	$EditQuery->close();
	//echo "You have edited your Restaurant Review <br/>";
	}
	else {
		echo "You cannot have an empty parameter.";
	}
}
	

if(isset($_POST['delete'])) {
	$DeleteQuery = $con->prepare("DELETE FROM MyRestaurants WHERE id = '$_POST[delete]'");
	$DeleteQuery->execute();
	$DeleteQuery->close();
	//echo "You have deleted your Restaurant Review <br/>";
	}




?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Restaurant Hub Site</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		
		<link href="css/styles.css" rel="stylesheet">
</head>
<body style = "background-color:#F0F8FF">
 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="videos.php">Hub Site</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
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
    </nav><br/>

<div class="col-md-2" id="leftCol">
                
        <div class="well"> 
             
				<h1>Favorite's List</h1><hr><p>
<?php

		
		if(isset($_POST['favorites'])){
	
$rest = $con->prepare("SELECT * FROM MyFavorites WHERE Restaurant='$_POST[favorites]' && Username = '$_SESSION[Username]'");
$rest->execute();
$resultst = $rest->get_result();
$rowt = $resultst->fetch_assoc();
if($rowt>0){

	echo "Already added to favorites.<br/>";

}
	
	else{

	$favQuery = $con->prepare("INSERT INTO MyFavorites (Restaurant, Username) VALUES ('$_POST[favorites]','$_SESSION[Username]')");         
	$favQuery->execute();
	$favQuery->close();
	echo "You have added ".$_POST['favorites']." Restaurant to your Favorite List <br/>";
	}
	$resultst->close();
}


if(isset($_POST['deletefav'])) {
	$DeleteQuery1 = $con->prepare("DELETE FROM MyFavorites WHERE id = '$_POST[deletefav]'");
	$DeleteQuery1->execute();
	$DeleteQuery1->close();
	echo "You have deleted the Restaurant from your Favorite List. <br/>";
	}

$read2 = "SELECT * FROM MyFavorites WHERE Username = '$_SESSION[Username]'";        
		$favorites = $con->query($read2);
		if($favorites->num_rows>0){
			echo '<table class="table table-bordered table-hover table-striped">';
			echo '<tr>Restaurant Name</tr>';
			
		while($rows1=$favorites->fetch_assoc()){
			echo '<tr><td>'.$rows1['Restaurant'].'</td>';
			echo '<form action = "videos.php" method="POST">';
			echo "<td><input type='hidden' name='deletefav' value=".$rows1["id"]."><input type='submit' class='btn btn-sm btn-danger' value='Remove' name='delete2'></td></form></tr>";
		}
		echo '</table>';
		}
		else{
			echo "No Favorites added to your list yet.";
		}
		$favorites->close();

?>
		</p>
         
</div>

          </div>		  
<div class="container"><font size = "4">
<div class="col-md-10">
	<div class="row"><br/>
  			
      	
<?php

echo "<h1>Welcome ".$_SESSION['Username']." to Restaurant Hub Reviews.</h1><hr>";

?>
<h1>Review Form</h1>
<div class="col-md-4" >
	<div class="well"> 
	<form method = "POST" action="">
		Restaurant: <input type="text" name="restname" required><br/>
		Food Type:  <input type="text" name="food" required><br/>
		Rating(1-10): <input type="number" name="rating" min="1" max="10" required><br/>
		Recommendation:<input type="radio" name="recommend" value=1 checked required>Yes
		<input type="radio" name="recommend" value=0>No
		<br/>
		 <div class="form-group">
                                <label>Review</label><br/>
                                <textarea class="form-control" rows="3" name="review"></textarea>
                            </div>
		<input type="submit" name="addMovie" class="btn btn-primary" value="Add Restaurant"><br/>
	</form>
	<?php
	
		if(isset($_POST['addMovie'])){
				//$_POST['available']=1;
			$AddQuery = $con->prepare ("INSERT INTO MyRestaurants (RestName, FoodType, Rating, Recommend, Review, Username) VALUES ('$_POST[restname]','$_POST[food]','$_POST[rating]','$_POST[recommend]','$_POST[review]','$_SESSION[Username]')");         
			//mysql_query($AddQuery, $con);

			$AddQuery->execute();
			$AddQuery->close();
			echo "Restaurant Added.";
			};
			
	?>
	</div>
	</div>
<div class="row">
  <div class="col-md-6" id="rightCol">
	<?php

echo "<h1>".$_SESSION['Username']."'s Review List</h1>";

?>
<?php

		$readReviews = "SELECT * FROM MyRestaurants WHERE Username = '$_SESSION[Username]'";        
		$reads = $con->query($readReviews);
		if($reads->num_rows>0){
			echo '<table class="table table-bordered table-hover table-striped">';
			echo '<th>Restaurant Name</th><th>Food Type</th><th>Rating</th><th>Recommend</th><th>Edit</th><th>View Review</th><th>Delete Review </th>';
			

		while($rows=$reads->fetch_assoc()){
			if($rows["Recommend"]==0){
		//echo '<form method="POST">';
		echo '<tr><td><form action = "videos.php" method="POST"><input type="text" name="restN" value="'.$rows['RestName'].'"/></td><td><input type="text" name="types" value="'.$rows['FoodType'].'"/></td><td><input type="number" name="rates" value="'.$rows['Rating'].'" min="1" max="10"/></td>
		<td>Thumbs Down  <input type="radio" name="rec" value=1/>  Yes
		
		<input type="radio" name="rec" value=0/>No </td>';
		echo '<td><input type="hidden" name="edit" value="'.$rows['id'].'"/><input type="submit" class="btn btn-sm btn-warning" value="Update" name="edit1"/></form></td>';
		
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="readEdit" value="'.$rows['id'].'"/><input type="submit" class="btn btn-sm btn-info" value="Read/Edit" name="read18"/></td></form>';
		
		
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="delete" value="'.$rows['id'].'"/><input type="submit" class="btn btn-sm btn-danger" value="Delete" name="delete1"/></td></form></tr>';
		}
		else{
		//echo '<form action = "videos.php" method="POST">';
		echo '<tr><td><form action = "videos.php" method="POST"><input type="text" name="restN" value="'.$rows['RestName'].'"/></td><td><input type="text" name="types" value="'.$rows['FoodType'].'"/></td><td><input type="number" name="rates" value="'.$rows['Rating'].'" min="1" max="10"/></td>
		<td>Thumbs Up  <input type="radio" name="rec" value=1/>  Yes
		
		<input type="radio" name="rec" value=0/>  No </td>';
		echo '<td><input type="hidden" name="edit" value="'.$rows['id'].'"/><input type="submit" class="btn btn-sm btn-warning" value="Update" name="edit1"/></form></td>';
		
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="readEdit" value="'.$rows['id'].'"/><input type="submit" class="btn btn-sm btn-info" value="Read/Edit" name="read18"/></td></form>';
		
		
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="delete" value="'.$rows['id'].'"/><input type="submit" class="btn btn-sm btn-danger" value="Delete" name="delete1"/></td></form></tr>';
		}}
		echo "</form>";
		echo "</table>";

		
	}
	else{
		echo "<br/>You have written no Restaurant Reviews.";
	}
		$reads->close();

		echo "</p>";

if(isset($_POST['editRev'])) {
	$EditQuery1 = $con->prepare("UPDATE MyRestaurants SET Review = '$_POST[yourReview]' WHERE id = '$_POST[editRev]'");
	$EditQuery1->execute();
	$EditQuery1->close();
	echo "You have updated your Restaurant Review <br/>";

}				
if(isset($_POST['readEdit'])){
	$readReviewss = "SELECT * FROM MyRestaurants WHERE id='$_POST[readEdit]'";            
	$readss = $con->query($readReviewss);
	if($readss->num_rows>0){
		while($rowss=$readss->fetch_assoc()){
			echo '<p>';
			echo '<table class="table table-bordered table-hover table-striped">';
			echo '<th>Your Review for '.$rowss["RestName"].'</th>';
			echo '<form action = "videos.php" method="POST"><tr><td><input type="text" name="yourReview" value="'.$rowss['Review'].'"/>';
			echo "<input type='hidden' name='editRev' value=".$rowss["id"]."/><input type='submit' class='btn btn-sm btn-warning' value='Update Review' name='edit123'/></td></tr></form>";
			echo '</table>';
			echo '</p>';
		}
	}
	$readss->close();
	//echo "Movie has now been checked in.<br/>";
};


		
?>

</div>
	</div>
	
<?php
 $curr = $_SESSION['Username'];

$stmt = $con->prepare("SELECT DISTINCT FoodType FROM MyRestaurants");
$stmt->execute();
	
	$catList= NULL;
	$stmt->bind_result($catList);
	echo '<form method="POST">
	<select name="lists">
		<option value="allMovies" name="allMovies">All Types of Restaurants</option>';
	
		while($stmt->fetch()){
			$list = $catList;
			if ($list != NULL) {
				echo '<option value="'.$list.'">'.$list.'</option>';
			}
		}
	echo '</select><input type="submit" class="btn btn-primary" value="Filter By Type"></form>';
	
	$stmt->close();

	

if (isset($_POST["lists"])) {
      if($_POST["lists"] == "allMovies"){
      	$catFilter = "SELECT id, RestName, FoodType, Rating, Recommend, Review, Username FROM MyRestaurants ";
    }
   
   	 else{
     
      $catFilter = "SELECT id, RestName, FoodType, Rating, Recommend, Review, Username FROM MyRestaurants WHERE FoodType = '".$_POST["lists"]."'";
    }}
 else{$catFilter ="SELECT id, RestName, FoodType, Rating, Recommend, Review, Username FROM MyRestaurants";}


 $CatStmt = $con->prepare($catFilter);
 $CatStmt->execute();
 
$uid = NULL;
$urestname = NULL;
$ufoodtype = NULL;
$urating = NULL;
$urecommend = NULL;
$ureview = NULL;
$uusername = NULL;

$CatStmt->bind_result($uid, $urestname, $ufoodtype, $urating, $urecommend, $ureview, $uusername);

	echo "<div class='row'>";
	echo '<h1>Restaurant Hub Library Review List</h1><table class="table table-bordered table-hover table-striped">';
	echo '<th>Name  </th><th>Type  </th><th>Rating(1-10)  </th><th>Recommend  </th><th>Written By  </th><th>View Review  </th><th>Add To Favorites  </th>';
	while($CatStmt->fetch()){
		if($_SESSION['Username']===$uusername && $urecommend===0){
		echo '<tr><td>'.$urestname.'</td><td>'.$ufoodtype.'</td><td>'.$urating.'</td><td>Thumbs Down</td><td>'.$uusername.'</td>';
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="read" value="'.$uid.'"/><input type="submit" class="btn btn-sm btn-info" value="Read the Review" name="read1"/></td></form>';
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="favorites" value="'.$urestname.'"/><input type="submit" class="btn btn-sm btn-success" value="Add to Your Favorite List" name="favorite1"></td></tr></form>';

		}
		else if($_SESSION['Username']===$uusername && $urecommend===1){

		echo '<tr><td>'.$urestname.'</td><td>'.$ufoodtype.'</td><td>'.$urating.'</td><td>Thumbs Up</td><td>'.$uusername.'</td>';
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="read" value="'.$uid.'"/><input type="submit" class="btn btn-sm btn-info" value="Read the Review" name="read1"/></td></form>';
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="favorites" value="'.$urestname.'"/><input type="submit" class="btn btn-sm btn-success" value="Add to Your Favorite List" name="favorite1"></td></tr></form>';

	}
		else if($_SESSION['Username']!=$uusername && $urecommend===0){

		echo '<tr><td>'.$urestname.'</td><td>'.$ufoodtype.'</td><td>'.$urating.'</td><td>Thumbs Down</td><td>'.$uusername.'</td>';
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="read" value="'.$uid.'"/><input type="submit" class="btn btn-sm btn-info" value="Read the Review" name="read1"/></td></form>';
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="favorites" value="'.$urestname.'"/><input type="submit" class="btn btn-sm btn-success" value="Add to Your Favorite List" name="favorite1"></td></tr></form>';

		}
		else{

		echo '<tr><td>'.$urestname.'</td><td>'.$ufoodtype.'</td><td>'.$urating.'</td><td>Thumbs Up</td><td>'.$uusername.'</td>';
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="read" value="'.$uid.'"/><input type="submit" class="btn btn-sm btn-info" value="Read the Review" name="read1"/></td></form>';
		echo '<form action = "videos.php" method="POST">';
		echo '<td><input type="hidden" name="favorites" value="'.$urestname.'"/><input type="submit" class="btn btn-sm btn-success" value="Add to Your Favorite List" name="favorite1"></td></tr></form>';

		}

}
echo "</table>";
echo '</div>';
$CatStmt->close();




if(isset($_POST['read'])){
	$readReview = "SELECT * FROM MyRestaurants WHERE id='$_POST[read]'";            
	$read = $con->query($readReview);
	if($read->num_rows>0){
		while($row=$read->fetch_assoc()){
			echo "<hr><div class='well'>";
			echo '<table class="table table-bordered table-hover table-striped">';
			echo "<th><tr>Review for ".$row['RestName']."</tr></th>";
			echo "<tr><td>".$row['Review']."</td></tr>";
			echo '</table></div>';
			//echo "add to favorites:";
			//echo '<form action = "videos.php" method="POST">';
			//echo "<td><input type='hidden' name='favorites' value=".$row['RestName']."><input type='submit' value='Add to favorites list' name='read11'></td></tr></form>";

		}
	}
	$read->close();
	//echo "Movie has now been checked in.<br/>";
};


?>
				
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
