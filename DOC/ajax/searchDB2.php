<?php
require "../snippets/dbConn.php";
require "../snippets/SQLTools.php";
require "../snippets/utils.php";
session_start();
$keys = array_keys($_GET);
	$query = "SELECT DHR.serviceID, DHR.firstName, DHR.lastName, DHR.address, DHR.phoneNumber, DHR.email, DHR.computerModel, DHR.serviceRequested, DHR.extraParts, DHR.serviceProvided, DHR.complete, Du1.firstName as CreatorF, Du1.lastName as CreatorL, Du2.firstName as OpenerF, Du2.lastName as OpenerL, Du3.firstName as CloserF, Du3.lastName as CloserL, Du4.firstName as DelegatedToF, Du4.lastName as DelegatedToL, DHR.delegatedToId, DHR.requestTime, DHR.openTime, DHR.closeTime
			FROM DOC_Hardware_Records DHR
				Join DOC_Users Du1 on DHR.creatorId = Du1.userId
				Join DOC_Users Du2 on DHR.openerId = Du2.userId
				Join DOC_Users Du3 on DHR.closerId = Du3.userId 
				Join DOC_Users Du4 on DHR.delegatedToId = Du4.userId WHERE ";
/*foreach($keys as $key)
{
	if(!empty($_GET[$key]))
	{
		$query = $query . $key . " = '" . $_GET[$key] . "' AND ";
	}
}*/

function notempty($var) {
    return ($var==="0"||$var);
}

$antiInject = array();
if(notempty($_GET['firstName']))
{
	$query .= "DHR.firstName = :firstName AND ";
	$antiInject[":firstName"] = $_GET['firstName'];
}
if(notempty($_GET['lastName']))
{
	$query .= "DHR.lastName = :lastName AND ";
	$antiInject[":lastName"] = $_GET['lastName'];
}
if(notempty($_GET['address']))
{
	$query .= "DHR.address = :address AND ";
	$antiInject[":address"] = $_GET['address'];
}
if(notempty($_GET['phoneNumber']))
{
	$query .= "DHR.phoneNumber = :phoneNumber AND ";
	$antiInject[":phoneNumber"] = $_GET['phoneNumber'];
}
if(notempty($_GET['email']))
{
	$query .= "DHR.email = :email AND ";
	$antiInject[":email"] = $_GET['email'];
}
if(notempty($_GET['computerModel']))
{
	$query .= "DHR.computerModel = :computerModel AND ";
	$antiInject[":computerModel"] = $_GET['computerModel'];
}
if(notempty($_GET['serviceRequested']))
{
	$query .= "DHR.serviceRequested = :serviceRequested AND ";
	$antiInject[":serviceRequested"] = $_GET['serviceRequested'];
}
if(notempty($_GET['extraParts']))
{
	$query .= "DHR.extraParts = :extraParts AND ";
	$antiInject[":extraParts"] = $_GET['extraParts'];
}
if(notempty($_GET['requestTime']))
{
	$query .= "DHR.requestTime >= :requestTime AND ";
	$sqlDate = $_GET['requestTime'] . " 00:00:00";
	$antiInject[":requestTime"] = $sqlDate;
}
if(notempty($_GET['complete']))
{
	$query .= "DHR.complete = :complete AND ";
	$antiInject[":complete"] = $_GET['complete'];
}
$query = $query . " NULL IS NULL ORDER BY complete ASC, requestTime ASC";

/*DEBUG TEXT
echo $query . "<br/><br/>";
foreach($antiInject as $thing)
{
	echo $thing;
}
echo "<br/><br/>";
/*DEBUG TEXT*/

$ret = executeSQL_Safe_Manual($query, $dbConn, $antiInject);
$getUsers = "SELECT * FROM DOC_Users";
$extraInfo = executeSQL($getUsers, $dbConn);
//SQLTable($ret, $keys);
foreach($ret as $a)
{
	echo "<div style='display:inline-block'>";
	drawTicket2($a, $extraInfo, $_SESSION['userID']);
	echo "</div>";
	echo "  ";
}
?>