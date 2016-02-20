<?php
	require "../snippets/dbConn.php";
	require "../snippets/SQLTools.php";
	require "../snippets/utils.php";
	session_start();
	$com0 = "UPDATE DOC_Timestamps SET timeOut = :timeOut WHERE timestampId=:id";
	executeSQL_Safe_U($com0, $dbConn, ":timeOut", date("Y-m-d H:i:s"), ":id", $_SESSION['sessionId']);
	$com1 = "SELECT timestampId, timeIn, timeOut, forgotSignout, TIMESTAMPDIFF(HOUR, timeIn, timeOut) as hours, TIMESTAMPDIFF(MINUTE, timeIn, timeOut) as minutes, TIMESTAMPDIFF(SECOND, timeIn, timeOut) as seconds FROM DOC_Timestamps WHERE userId = :id ORDER BY timeIn ASC";
	$ret = executeSQL_Safe($com1, $dbConn, ":id", $_SESSION['userID']);
	function valid($time)
	{
		if($time['forgotSignout'] == 0)
		{
			return "Valid";
		}else{
			return "Invalid";
		}
	}
	foreach($ret as $time)
	{
		echo $time['timeIn'] . "," . $time['timeOut'] . "," . gmdate("H:i:s", $time['seconds']) . "," . valid($time) . "\n";
	}
?>