<?php
require "../snippets/dbConn.php";
require "../snippets/SQLTools.php";
require "../snippets/utils.php";
session_start();
$com = "SELECT DHR.serviceID, DHR.firstName, DHR.lastName, DHR.address, DHR.phoneNumber, DHR.email, DHR.computerModel, DHR.serviceRequested, DHR.extraParts, DHR.serviceProvided, DHR.serviceProvided, DHR.complete, Du1.firstName as CreatorF, Du1.lastName as CreatorL, Du2.firstName as OpenerF, Du2.lastName as OpenerL, Du3.firstName as CloserF, Du3.lastName as CloserL, Du4.firstName as DelegatedToF, Du4.lastName as DelegatedToL, DHR.delegatedToId, DHR.requestTime, DHR.openTime, DHR.closeTime
			FROM DOC_Hardware_Records DHR
				Join DOC_Users Du1 on DHR.creatorId = Du1.userId
				Join DOC_Users Du2 on DHR.openerId = Du2.userId
				Join DOC_Users Du3 on DHR.closerId = Du3.userId 
				Join DOC_Users Du4 on DHR.delegatedToId = Du4.userId
			WHERE DHR.complete = 0 ORDER BY DHR.requestTime DESC";
$ret = executeSQL_Safe($com, $dbConn);
$getUsers = "SELECT * FROM DOC_Users";
$extraInfo = executeSQL($getUsers, $dbConn);
foreach($ret as $row)
{
	drawTicket2($row, $extraInfo, $_SESSION['userID']);
}

?>