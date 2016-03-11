<?php
require "../snippets/dbConn.php";
require "../snippets/SQLTools.php";
require "../snippets/utils.php";
session_start();
	$query = "SELECT complete FROM DOC_Hardware_Records WHERE serviceID = :serviceId ";
	$ret = executeSQL_Safe($query, $dbConn, ":serviceId", $_GET["serviceId"]);
	$newId = $ret[0]["complete"] + 1;
	//echo $newId;
	//echo $_SESSION['userID'];
	//-----------------------------------------
	if($newId == 1)
	{
		$com2 = "UPDATE DOC_Hardware_Records SET complete=" . $newId . ", openTime = :openTime, openerId = :openerId, delegatedToId = :delegatedToId WHERE serviceID=:id";
		executeSQL_Safe_U($com2, $dbConn, ":id", $_GET["serviceId"], ":openTime", date("Y-m-d H:i:s"), ":openerId", $_SESSION['userID'], ":delegatedToId", $_GET['delegatedToId']);
	}else{
		$com2 = "UPDATE DOC_Hardware_Records SET complete=2, serviceProvided=:service, closeTime = :closeTime, closerId = :closerId WHERE serviceID=:id";
		executeSQL_Safe_U($com2, $dbConn, ":id", $_GET["serviceId"], ":closeTime", date("Y-m-d H:i:s"), ":closerId", $_SESSION['userID'], ":service", $_GET["service"]);
	}
	echo "Service Ticket #" . $_GET["serviceId"] . " updated.";
?>