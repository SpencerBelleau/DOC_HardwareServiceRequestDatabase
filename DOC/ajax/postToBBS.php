<?php
    require "../snippets/dbConn.php";
	require "../snippets/SQLTools.php";
	require "../snippets/utils.php";
	session_start();
	$com1 = "INSERT INTO DOC_BBS (userId, message) VALUES (:userId, :message)";
	executeSQL_Safe_U($com1, $dbConn, ":userId", $_SESSION['userID'], ":message", $_GET['message']);
?>