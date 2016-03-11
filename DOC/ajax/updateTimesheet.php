<?php
require "../snippets/dbConn.php";
require "../snippets/SQLTools.php";
require "../snippets/utils.php";
session_start();
$com0 = "UPDATE DOC_Timestamps SET timeOut = :timeOut, finished = 0 WHERE timestampId=:id";
executeSQL_Safe_U($com0, $dbConn, ":timeOut", date("Y-m-d H:i:s"), ":id", $_SESSION['sessionId']);
?>