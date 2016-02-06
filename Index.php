<?php
	require "snippets/dbConn.php";
	require "snippets/SQLTools.php";
	require "snippets/utils.php";
	
	if (isset($_POST['submission']))
	{
		echo "New submission made";
		$com2 = "INSERT INTO DOC_Hardware_Records (firstName, lastName, computerModel, serviceRequested, extraParts, complete) VALUES (:firstName, :lastName, :computerModel, :serviceRequested, :extraParts, 0)";
		executeSQL_Safe_U($com2, $dbConn, ":firstName", $_POST['firstName'], ":lastName", $_POST['lastName'], ":computerModel", $_POST['computerModel'], ":serviceRequested", $_POST['serviceRequested'], ":extraParts", $_POST['extraParts']);
	}
?>
<!DOCTYPE html>
<style>
	h1, h2{
		text-align:center;
	}
	table{
		margin-left:auto;
		margin-right:auto;
	}
</style>
<body>
<h1>TEST</h1>

<table border=1>
	<form method="post">
	<input type="hidden" name="submission" val="true">
	<tr>
		<td colspan=2>
			<h3 style="text-align:center">New Service Request</h3>
		</td>
	</tr>
	<tr>
		<td>
			First Name: <input type="text" name="firstName">
		</td>
		<td>
			Last Name: <input type="text" name="lastName">
		</td>
	</tr>
	<tr>
		<td>
			Computer Model: <input type="text" name="computerModel">
		</td>
		<td>
			Service Requested: <input type="text" name="serviceRequested">
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
	$com1 = "SELECT * FROM DOC_Hardware_Records";
	$fetched = executeSQL($com1, $dbConn);
	foreach($fetched as $a)
	{
		if($a['complete'] == 0)
		{
			$a['complete'] = "false";
		}else{
			$a['complete'] = "true";
		}
	}
	SQLTable($fetched, array("ID", "First Name", "Last Name", "Computer Model", "Service Requested", "Extra Parts", "Finished", "Time Requested"));
?>

</body>