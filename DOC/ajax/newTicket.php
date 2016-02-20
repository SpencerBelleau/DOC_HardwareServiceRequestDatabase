<?php
	require "../snippets/dbConn.php";
	require "../snippets/SQLTools.php";
	require "../snippets/utils.php";
	session_start();
	
	$com2 = "INSERT INTO DOC_Hardware_Records (firstName, lastName, address, phoneNumber, email, computerModel, serviceRequested, extraParts, complete, creatorId) VALUES (:firstName, :lastName, :address, :phoneNumber, :email, :computerModel, :serviceRequested, :extraParts, 0, :creatorId)";
	executeSQL_Safe_U($com2, $dbConn, ":firstName", $_GET['firstName'], ":lastName", $_GET['lastName'], ":address", $_GET['address'], ":phoneNumber", $_GET['phoneNumber'], ":email", $_GET['email'], ":computerModel", $_GET['computerModel'], ":serviceRequested", $_GET['serviceRequested'], ":extraParts", $_GET['extraParts'], ":creatorId", $_SESSION['userID']);
	
	echo "<strong>New Ticket Submitted</strong>"
?>