<?php
//Connect to the database
	$servername = "localhost";
	$username = "AngTsalas";
	$password = "h8f7sd8f7hsd8f7sh8fs";
	$dbname = "wda";
	$userid = 1;


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}