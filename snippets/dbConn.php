<?php
$host = "localhost";
$dbname = "bell6442";
$username = "bell6442"; 
$password = "secret";

$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = ""
			
?>