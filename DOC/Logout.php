<?php
	require "snippets/dbConn.php";
	require "snippets/SQLTools.php";
	require "snippets/utils.php";
    session_start();
	$com2 = "UPDATE DOC_Timestamps SET timeOut = :timeOut WHERE timestampId=:id";
	executeSQL_Safe_U($com2, $dbConn, ":timeOut", date("Y-m-d H:i:s"), ":id", $_SESSION['sessionId']);
	session_destroy();
	header("Location:Login.php");
?>