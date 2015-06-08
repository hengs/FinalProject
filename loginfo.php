<?php

session_start();

if(isset($_POST['login'])){
$username = $_POST['usernames'];
$password = $_POST['passwords'];

include "creds.php";

$rest = $con->prepare("SELECT 'id' FROM Login WHERE Username='$_POST[usernames]' AND Password='$_POST[passwords]' LIMIT 1");
$rest->execute();
$resultss = $rest->get_result();
$rows = $resultss->fetch_assoc();
if($rows>0){


	//$_SESSION['login']= $_POST['login'];
	//$_SESSION['Username']= $row['Username'];
	$_SESSION['id']= $rows['id'];
	//$_SESSION['Email']= $rows['Email'];
}
//rest->close();

$res = $con->prepare("SELECT * FROM Login WHERE Username='$_POST[usernames]' AND Password='$_POST[passwords]' LIMIT 1");
$res->execute();
$results = $res->get_result();
$row = $results->fetch_assoc();
if($row>0){


	//$_SESSION['login']= $_POST['login'];
	$_SESSION['Username']= $row['Username'];
	$_SESSION['id']= $row['id'];
	$_SESSION['Email']= $row['Email'];
	header("Location: videos.php");

}
else{
	echo '<script>
				 
					alert("Username and Password do not match. Please try again.");
		
					</script>';
	session_destroy();
}
$res->close();
}
?>