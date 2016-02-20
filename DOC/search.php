<?php
	session_start();
	if(empty($_SESSION['username']))
	{
		header("Location: Login.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>search</title>
		<meta name="description" content="">
		<meta name="author" content="Spencer Belleau">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		
		<!--External Style Sheet-->
		<link rel="stylesheet" type="text/css" href="MyStyles.css">
	<style>
	h1, h2, h3{
		text-align:center;
	}
	.table{
		margin-left:auto;
		margin-right:auto;
		border:1px solid black;
		border-radius:4px;
		width:450px;
	}
	.ui-datepicker-other-month.ui-state-disabled:not(.my_class) span{
		background-color:white;
    	color: red;    
	}
	#ui-datepicker-div {display: none;}
	/*
	button{
		width:100%;
		background-color: lightgrey;
	    border: 1px solid black;
	    border-radius: 2px;
	    color: #002544;
	    padding: 15px 32px;
	    text-align: center;
	    text-decoration: none;
	    display: inline-block;
	    font-size: 16px;
	    -webkit-transition-duration: 0.2s;
    	transition-duration: 0.2s;
	}
	button:hover{
		background-color: white;
	}*/
	</style>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script>
    	$(
			function(){
					$("#creationDate").datepicker({
						dateFormat: 'yy-mm-dd',
				        altField: ".date_alternate",
				        altFormat: "yy-mm-dd"
	
					});
				}
		);
    </script>
	</head>

	<body style="background-color:grey">
		<table class="roundedTable" style="width:450px;background-color:lightblue">
			<tr>
				<td colspan=2>
					<h3 style="text-align:center">Search Service Requests</h3>
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					First Name:
				</td>
				<td>
					<input id="firstName" style="width:98%" type="text" name="firstName">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Last Name:
				</td>
				<td>
					<input id="lastName" style="width:98%" type="text" name="lastName">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Address:
				</td>
				<td>
					<input id="address" style="width:98%" type="text" name="address">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Phone Number:
				</td>
				<td>
					<input id="phoneNumber" style="width:98%" type="text" name="phoneNumber">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					E-mail:
				</td>
				<td>
					<input id="email" style="width:98%" type="text" name="email">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Computer Model:
				</td>
				<td>
					<input id="computerModel" style="width:98%" type="text" name="computerModel">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Service Requested:
				</td>
				<td>
					<input id="serviceRequested" style="width:98%" type="text" name="serviceRequested">
				</td>
			</tr>
			<tr>
				<td colspan=2 style="text-align:center">
					List Extra Parts: <br/><textarea id="extraParts" name="extraParts" rows=4></textArea>
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Creation on/after:
				</td>
				<td>
					<input type="text" style="width:98%" id="creationDate" name="requestTime">
				</td>
			</tr>
			<tr>
				<td style="width:150px">
					Status:
				</td>
				<td>
					<select name="status" id="status">
						<option value="">
							All
						</option>
						<option value="0">
							New
						</option>
						<option value="1">
							Open
						</option>
						<option value="2">
							Complete
						</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<button id="search" class="greyButton" style="width:100%">Search!</button>
				</td>
			</tr>
		</table>
		<br/>
		<div id="results">
			
		</div>
		
		<script>
			$(document).on('click', 'button', function(){
				if($(this).attr('id') == "search")
				{
					$.ajax(
						{
		            		type: "get",
		            		url: "ajax/searchDB.php",
		            		data: {
		            		"firstName": $("#firstName").val(),
		            		"lastName": $("#lastName").val(),
		            		"address": $("#address").val(),
		            		"phoneNumber": $("#phoneNumber").val(),
		            		"email": $("#email").val(),
		            		"computerModel": $("#computerModel").val(),
		            		"serviceRequested": $("#serviceRequested").val(),
		            		"extraParts": $("#extraParts").val(),
		            		"requestTime": $("#creationDate").val(),
		            		"complete": $("#status").val()
		            		},
		            		success: 
		            			function(data,status) {
		                			$("#results").html(data);
		              			},
		         		}
	         		);
				}else{
					//$("#results").html($(this).attr('data-ticketid') + " TEST");
					$.ajax(
						{
		            		type: "get",
		            		url: "ajax/updateServiceTicket.php",
		            		data: {
		            		"serviceId": $(this).attr('data-ticketid'),
		            		},
		            		success: 
		            			function(data2,status) {
		                			$.ajax(
									{
					            		type: "get",
					            		url: "ajax/searchDB.php",
					            		data: {
					            		"firstName": $("#firstName").val(),
					            		"lastName": $("#lastName").val(),
					            		"address": $("#address").val(),
					            		"phoneNumber": $("#phoneNumber").val(),
					            		"email": $("#email").val(),
					            		"computerModel": $("#computerModel").val(),
					            		"serviceRequested": $("#serviceRequested").val(),
					            		"extraParts": $("#extraParts").val(),
					            		"requestTime": $("#creationDate").val(),
					            		"complete": $("#status").val()
					            		},
					            		success: 
					            			function(data,status) {
					                			$("#results").html(data);
					              			},
					         		}
				         		);
				         		//End inner AJAX
		              		},
		         		}
	         		);
	         		//End outer AJAX
				}
			})
		</script>
	</body>
</html>
