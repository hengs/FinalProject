<?php

error_reporting(E_ALL);
  ini_set('display_errors','On');
$host = "oniddb.cws.oregonstate.edu";
$db = "hengs-db";
$dbuser = "hengs-db";
$pw = "DXB2D0DXn9smG486";
//include "login.php";

$con = new mysqli($host, $db, $pw, $dbuser);
if (!$con|| $con->connect_errno) {
    echo "Connection Failure: (" . $con->connect_errno . ") " . $con->connect_error;
    exit(1);
}
?>