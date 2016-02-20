<?php
require "../snippets/dbConn.php";
require "../snippets/SQLTools.php";
require "../snippets/utils.php";
$com = "SELECT DHR.serviceID, DHR.firstName, DHR.lastName, DHR.address, DHR.phoneNumber, DHR.email, DHR.computerModel, DHR.serviceRequested, DHR.extraParts, DHR.complete, Du1.firstName as CreatorF, Du1.lastName as CreatorL, Du2.firstName as OpenerF, Du2.lastName as OpenerL, Du3.firstName as CloserF, Du3.lastName as CloserL, DHR.requestTime, DHR.openTime, DHR.closeTime
			FROM DOC_Hardware_Records DHR
				Join DOC_Users Du1 on DHR.creatorId = Du1.userId
				Join DOC_Users Du2 on DHR.openerId = Du2.userId
				Join DOC_Users Du3 on DHR.closerId = Du3.userId 
			WHERE serviceID = :id";
$ret = executeSQL_Safe($com, $dbConn, ":id", $_GET['id']);
drawTicket($ret[0]);
?>