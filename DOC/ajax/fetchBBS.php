<?php
	require "../snippets/dbConn.php";
	require "../snippets/SQLTools.php";
	require "../snippets/utils.php";
	
	$com1 = "SELECT DU.username as username, DU.firstName as firstName, DU.lastname as lastName, DBBS.message as message, DBBS.postTime as postTime
				FROM DOC_BBS DBBS
				JOIN DOC_Users DU on DBBS.userId = DU.userId
			ORDER BY postTime DESC";
	$ret = executeSQL($com1, $dbConn);
	foreach($ret as $row)
	{
		drawBBSMessage($row);
		echo "<br/>";
	}
?>