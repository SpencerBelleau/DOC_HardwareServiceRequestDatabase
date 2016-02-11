<?php
	session_start();
    //sha1 length is 40
    //sha2 length is 64
    require "snippets/dbConn.php";
	require "snippets/SQLTools.php";
	require "snippets/utils.php";
	
	if(isset($_POST['LoginForm']))
	{
		$com1 = "SELECT userId, username, password, firstName, lastName FROM DOC_Users WHERE username = :username";
		$ret = executeSQL_Safe($com1, $dbConn, ":username", $_POST['username']);
		if (empty($ret))
		{
			echo "Wrong Password";
		}
		else if($ret[0]['password'] != sha1($_POST['password']))
		{
			echo "Wrong Password";
		}
		else
		{
			$_SESSION['username'] = $ret[0]['username'];
			$_SESSION['userID'] = $ret[0]['userId'];
			$_SESSION['name'] = $ret[0]['firstName'] . " " . $ret[0]['lastName'];
			header("Location: Index.php");
		}
	}
?>

<!DOCTYPE html>
<head>
	
</head>
<style>
	h1, h2{
		text-align:center;
	}
	table{
		margin-left:auto;
		margin-right:auto;
		border:1px solid black;
		border-radius:4px;
		width:450px;
		background-color:#002544;
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

<body style="background-color:grey;font-family:Verdana">
	<table>
		<tr>
			<td style="text-align:center;color:#A29051" colspan=2><h4>Digital Otter Center Hardware Service Request Login Form</h4></td>
		</tr>
		<form method="post" id="loginForm">
			<tr>
				<td style="width:150px;color:#A29051">
					<b>Username:</b> 
				</td>
				<td>
					<input type="text" name="username">
				</td>
			</tr>
			<tr>
				<td style="width:150px;color:#A29051">
					<b>Password: </b>
				</td>
				<td>
					<input type="password" name="password">
				</td>
			</tr>
			<tr>
				<td>
					<br/>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<button type="submit" form="loginForm" name="LoginForm" value = "Login!"><b style="font-size: 20px">Log In</b></button>
				</td>
			</tr>
		</form>
	</table>
</body>