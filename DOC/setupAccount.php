<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="../DOC/MyStyles.css">
	<title>Digital Otter Center</title>
</head>
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
</style>

<body style="background-color:#444444;font-family:Verdana">
<?php
	require "snippets/dbConn.php";
	require "snippets/SQLTools.php";
	require "snippets/utils.php";
	session_start();
	if(empty($_SESSION['username']))
	{
		header("Location: Login.php");
	}
	if(isset($_POST['LoginForm']))
	{
		if($_POST['password'] == $_POST['password2'] && $_POST['password'] != "")
		{
			$com0 = "UPDATE DOC_Users SET firstName = :f, lastName = :l, password = :p, setup = 1 WHERE userId=:id";
			executeSQL_Safe_U($com0, $dbConn, ":f", $_POST['firstName'], ":l", $_POST['lastName'], ":p", sha1($_POST['password']), ":id", $_SESSION['userID']);
			header("Location: Logout.php");
		}else{
			echo "<h3 style='color:red;text-align:center'>Passwords Do Not Match</h3>";
		}
	}
?>
	<table>
		<tr>
			<td style="text-align:center;color:white" colspan=2><h3>Set Up Your Account</h3></td>
		</tr>
		<form method="post" id="loginForm">
			<tr>
				<td style="width:150px;color:white;text-align:right">
					<b>First Name:  </b> 
				</td>
				<td>
					<input type="text" name="firstName">
				</td>
			</tr>
			<tr>
				<td style="width:150px;color:white;text-align:right">
					<b>Last Name:  </b> 
				</td>
				<td>
					<input type="text" name="lastName">
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
					<b>Re-Enter:</b>
				</td>
				<td>
					<input type="password" name="password2">
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<br/>
					<button type="submit"class="brownButton" form="loginForm" name="LoginForm" value = "Login!"><b style="font-size: 20px">Set Up</b></button>
				</td>
			</tr>
		</form>
	</table>
</body>