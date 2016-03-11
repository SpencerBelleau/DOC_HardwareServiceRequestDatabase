<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="../DOC/MyStyles.css">
	<title>Digital Otter Center</title>
	<style>
		h1, h2{
			text-align:center;
		}
		table{
			margin-left:auto;
			margin-right:auto;
			border:3px outset #0f245b;
			border-radius:4px;
			width:450px;
			background-color:#1f346b;
		}
		button{
			background-color: #A29051; /* Green */
	    	border: none;
	    	width:100%;
	    	border-radius:4px;
	    	color: #002544;
	    	padding: 10px 32px;
	    	text-align: center;
	    	text-decoration: none;
	    	display: inline-block;
	    	font-size: 16px;
		}
	</style>
</head>
<body style="background-color:#444444;font-family:Verdana">
<?php
	session_start();
    //sha1 length is 40
    //sha2 length is 64
    require "snippets/dbConn.php";
	require "snippets/SQLTools.php";
	require "snippets/utils.php";
	
	if(isset($_POST['LoginForm']))
	{
		$com1 = "SELECT userId, username, password, firstName, lastName, setup FROM DOC_Users WHERE username = :username";
		$ret = executeSQL_Safe($com1, $dbConn, ":username", $_POST['username']);
		if (empty($ret))
		{
			echo "<h3 style='color:red;text-align:center'>Wrong Password</h3>";
		}
		else if($ret[0]['password'] != sha1($_POST['password']))
		{
			echo "<h3 style='color:red;text-align:center'>Wrong Password</h3>";
		}else if($ret[0]['setup'] == 0)
		{
			$_SESSION['username'] = $ret[0]['username'];
			$_SESSION['userID'] = $ret[0]['userId'];
			$_SESSION['name'] = $ret[0]['firstName'] . " " . $ret[0]['lastName'];
			header("Location: setupAccount.php");
		}
		else
		{
			$_SESSION['username'] = $ret[0]['username'];
			$_SESSION['userID'] = $ret[0]['userId'];
			$_SESSION['name'] = $ret[0]['firstName'] . " " . $ret[0]['lastName'];
			//Check to see if last timestamp was closed
			$com1 = "SELECT timeOut, timestampId, finished FROM DOC_Timestamps WHERE userId = :id ORDER BY timestampId DESC";
			$ret = executeSQL_Safe($com1, $dbConn, ":id", $_SESSION['userID']);
			if(empty($ret))
			{
				$com2 = "INSERT INTO DOC_Timestamps (userId) VALUES (:id)";
				executeSQL_Safe_U($com2, $dbConn, ":id", $_SESSION['userID']);
				$com3 = "SELECT MAX(timestampId) as timeId FROM DOC_Timestamps WHERE userId = :id";
				$ret = executeSQL_Safe($com3, $dbConn, ":id", $_SESSION['userID']);
				$_SESSION['sessionId'] = $ret[0]['timeId'];
				header(proceed($_POST));
			}
			else if($ret[0]['finished'] == 0)
			{
				//If there's an unfinished log, check when it was last updated
				//$com2 = "UPDATE DOC_Timestamps SET timeOut = :timeOut, forgotSignout = 1 WHERE userId = :id AND timestampId = :timestampId";
				//executeSQL_Safe_U($com2, $dbConn, ":timeOut", date("Y-m-d H:i:s"), ":id",  $_SESSION['userID'], ":timestampId", $ret[0]['timestampId']);
				$com4 = "SELECT TIMESTAMPDIFF(MINUTE, timeOut, CURRENT_TIMESTAMP) as lastUpdate FROM DOC_Timestamps WHERE timestampId = :id";
				$ret2 = executeSQL_Safe($com4, $dbConn, ":id", $ret[0]['timestampId']);
				
				//If it's been 10 minutes or less
				if($ret2[0]['lastUpdate'] <= 10)
				{
					//Select this log and use it
					$_SESSION['sessionId'] = $ret[0]['timestampId'];
					header(proceed($_POST));
					//header("Location: ../Mockups/mockup.php");
				}else{
					//Close the log and make a new one
					$com5 = "UPDATE DOC_Timestamps SET finished = 1 WHERE timestampId=:id";
					executeSQL_Safe_U($com5, $dbConn, ":id", $ret[0]['timestampId']);
					
					$com2 = "INSERT INTO DOC_Timestamps (userId) VALUES (:id)";
					executeSQL_Safe_U($com2, $dbConn, ":id", $_SESSION['userID']);
					$com3 = "SELECT MAX(timestampId) as timeId FROM DOC_Timestamps WHERE userId = :id";
					$ret = executeSQL_Safe($com3, $dbConn, ":id", $_SESSION['userID']);
					$_SESSION['sessionId'] = $ret[0]['timeId'];
					header(proceed($_POST));
					/*if($_POST['interface'] == "complete")
					{
						//header("Location: ../Mockups/mockup.php");
					}
					else if($_POST['interface'] == "work")
					{
						//header("Location: ../Mockups/workInterface.php");
					}
					else
					{
						//header("Location: ../Mockups/delegationInterface.php");
					}*/
				}
				
				
			}else{
				$com2 = "INSERT INTO DOC_Timestamps (userId) VALUES (:id)";
				executeSQL_Safe_U($com2, $dbConn, ":id", $_SESSION['userID']);
				$com3 = "SELECT MAX(timestampId) as timeId FROM DOC_Timestamps WHERE userId = :id";
				$ret = executeSQL_Safe($com3, $dbConn, ":id", $_SESSION['userID']);
				$_SESSION['sessionId'] = $ret[0]['timeId'];
				header(proceed($_POST));
				//header("Location: ../Mockups/mockup.php");
			}
			//Make a new timestamp
		}
	}
	function proceed($_POST)
	{
		if($_POST['interface'] == "complete")
		{
			return("Location: ../Mockups/mockup.php");
		}
		else if($_POST['interface'] == "work")
		{
			return("Location: ../Mockups/workInterface.php");
		}
		else
		{
			return("Location: ../Mockups/delegationInterface.php");
		}
	}
?>
	<!--TEST-->
	<form method="post" id="loginForm">
	<table>
		<tr>
			<td style="text-align:center;color:white" colspan=2><h3>Digital Otter Center Service Request Login Form</h3></td>
		</tr>
			<tr>
				<td style="width:150px;color:white;text-align:right">
					<b>Username:  </b> 
				</td>
				<td>
					<input type="text" name="username">
				</td>
			</tr>
			<tr>
				<td style="width:150px;color:white;text-align:right">
					<b>Password:  </b>
				</td>
				<td>
					<input type="password" name="password">
				</td>
			</tr>
			<tr>
				<td style="width:150px;color:white;text-align:right">
					<b>Interface:</b>
				</td>
				<td>
					<select name="interface" id="interface">
						<option value="work">Ticket Completion Interface</option>
						<option value="delegate">Delegation Interface</option>
						<option value="complete">Admin Interface</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<br/>
					<button type="submit" class="brownButton" form="loginForm" name="LoginForm" value="Login!"><b style="font-size: 20px">Log In</b></button>
				</td>
			</tr>
	</table>
	</form>
</body>