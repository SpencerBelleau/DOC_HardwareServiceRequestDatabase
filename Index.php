<?php
	require "snippets/dbConn.php";
	require "snippets/SQLTools.php";
	require "snippets/utils.php";
	session_start();
	if(empty($_SESSION['username']))
	{
		header("Location: Login.php");
	}
	if (isset($_POST['submission']))
	{
		if($_POST['submission'] == "New")
		{
			echo "New submission made";
			$com2 = "INSERT INTO DOC_Hardware_Records (firstName, lastName, address, phoneNumber, email, computerModel, serviceRequested, extraParts, complete, creatorId) VALUES (:firstName, :lastName, :address, :phoneNumber, :email, :computerModel, :serviceRequested, :extraParts, 0, :creatorId)";
			executeSQL_Safe_U($com2, $dbConn, ":firstName", $_POST['firstName'], ":lastName", $_POST['lastName'], ":address", $_POST['address'], ":phoneNumber", $_POST['phoneNumber'], ":email", $_POST['email'], ":computerModel", $_POST['computerModel'], ":serviceRequested", $_POST['serviceRequested'], ":extraParts", $_POST['extraParts'], ":creatorId", $_SESSION['userID']);
		}else if($_POST['submission'] == "Complete"){
			echo "Service ticket " . $_POST['serviceID'] . " updated.";
			$com2 = "UPDATE DOC_Hardware_Records SET complete=2 WHERE serviceID=:id";
			executeSQL_Safe_U($com2, $dbConn, ":id", $_POST['serviceID']);
		}else if($_POST['submission'] == "Open"){
			echo "Service ticket " . $_POST['serviceID'] . " updated.";
			$com2 = "UPDATE DOC_Hardware_Records SET complete=1 WHERE serviceID=:id";
			executeSQL_Safe_U($com2, $dbConn, ":id", $_POST['serviceID']);
		}
	}
?>
<!DOCTYPE html>
<style>
	h1, h2, h3{
		text-align:center;
	}
	table{
		margin-left:auto;
		margin-right:auto;
		border:1px solid black;
		border-radius:4px;
		width:450px;
		background-color:
	}
</style>
<body style="background-color:grey">
<table style="background-color:#002544;width:1000px"><tr><td><h1 style="font-family: Verdana;color:#A29051">Digital Otter Center Hardware Service Request Form</h1></td></tr></table>
<?php
echo "<h3>Logged in as <a href='Logout.php'>" . $_SESSION['name'] . "</a>, click to log out</h3>";
?>

<table style="background-color:lightblue">
	<form method="post">
	<input type="hidden" name="submission" value="New">
	<tr>
		<td colspan=2>
			<h3 style="text-align:center">New Service Request</h3>
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			First Name:
		</td>
		<td>
			<input style="width:98%" type="text" name="firstName">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Last Name:
		</td>
		<td>
			<input style="width:98%" type="text" name="lastName">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Address:
		</td>
		<td>
			<input style="width:98%" type="text" name="address">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Phone Number:
		</td>
		<td>
			<input style="width:98%" type="text" name="phoneNumber">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			E-mail:
		</td>
		<td>
			<input style="width:98%" type="text" name="email">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Computer Model:
		</td>
		<td>
			<input style="width:98%" type="text" name="computerModel">
		</td>
	</tr>
	<tr>
		<td style="width:150px">
			Service Requested:
		</td>
		<td>
			<input style="width:98%" type="text" name="serviceRequested">
		</td>
	</tr>
	<tr>
		<td colspan=2 style="text-align:center">
			List Extra Parts: <br/><textarea name="extraParts" rows=4>[none]</textArea>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<input type="submit" value="Submit Request" style="width:100%">
		</td>
	</tr>
	</form>
</table>
<?php
	echo '<h2> Existing Service Requests </h2>';
	$com1 = "SELECT * FROM DOC_Hardware_Records ORDER BY complete ASC, requestTime ASC";
	$fetched = executeSQL($com1, $dbConn);
	echo "<table style='width:1500px;border-collapse: collapse;'><tr style='text-align:center;border: none;'><td style='border-right: solid 1px black;border-left: solid 1px black;'><h2>OPEN</h2></td><td style='border-right: solid 1px black;border-left: solid 1px black;'><h2>STARTED</h2></td><td style='border-right: solid 1px black;border-left: solid 1px black;'><h2>FINISHED</h2></td></tr><tr style='border: none;'><td valign='top' style='border-right: solid 1px black;border-left: solid 1px black;'>";
	foreach($fetched as $a)
	{
		if($a['complete'] == 0)
		{
			drawTicket($a);
			echo '<br/>';
		}
	}
	echo "</td><td valign='top' style='border-right: solid 1px black;border-left: solid 1px black;'>";
	foreach($fetched as $a)
	{
		if($a['complete'] == 1)
		{
			drawTicket($a);
			echo '<br/>';
		}
	}
	echo "</td><td valign='top' style='border-right: solid 1px black;border-left: solid 1px black;'>";
	foreach($fetched as $a)
	{
		if($a['complete'] == 2)
		{
			drawTicket($a);
			echo '<br/>';
		}
	}
	
	echo "</td></tr></table>";
	/*
	foreach($fetched as $a)
	{
		drawTicket($a);
		echo '<br/>';
		/*
		if($a['complete'] == 0)
		{
			$col = "style='background-color:LightCoral'";
		}else{
			$col = "style='background-color:LimeGreen'";
		}
		echo '<table border=1>';
		echo '<tr><td ' . $col . '>' . $a['firstName'] . '</td><td ' . $col . '>' . $a['lastName'] . '</td></tr>';
		echo '<tr><td colspan=2 ' . $col . '>' . $a['address'] . '</td></tr>';
		echo '<tr><td ' . $col . '>' . $a['phoneNumber'] . '</td><td ' . $col . '>' . $a['email'] . '</td></tr>';
		echo '<tr><td ' . $col . '>' . $a['computerModel'] . '</td><td ' . $col . '>' . $a['serviceRequested'] . '</td></tr>';
		echo '<tr><td colspan=2 ' . $col . '>' . $a['extraParts'] . '</td></tr>';
		if($a['complete'] == 0)
		{
			echo '<tr><form method="post"><td colspan=2>';
			echo '<input type="hidden" name="submission" value="Update">';
			echo '<input type="hidden" value="'. $a['serviceID'] .'" name="serviceID">';
			echo '<input style="width:100%" type="submit" value="Complete">';
			echo '</td></form></tr>';
		}
		echo '</table>';*/
	//}
	//SQLTable($fetched, array("ID", "First Name", "Last Name", "Computer Model", "Service Requested", "Extra Parts", "Finished", "Time Requested"));
?>

</body>