<?php
	require "../DOC/snippets/dbConn.php";
	require "../DOC/snippets/SQLTools.php";
	require "../DOC/snippets/utils.php";
	session_start();
	if(empty($_SESSION['username']))
	{
		header("Location: ../DOC/Login.php");
	}
?>
<!DOCTYPE html>
<head>
	<!-- Title and other stuff -->
	<title>Digital Otter Center</title>
	<meta name="author" content="Spencer Belleau">
	<!-- Stylesheet and resources -->
	<style>
		.titleTable {
			background-color:#002544;
			margin:auto;
			border:1px solid black;
			border-radius:4px;
			width:80%;
		}
		.titleText {
			font-family:Verdana;
			color:#A29051;
			text-align:center;
		}
		.mainTable{
			margin-left:auto;
			margin-right:auto;
			width:80%;
		}
		.outlineTable{
			margin-left:auto;
			margin-right:auto;
			border:1px solid black;
			border-radius:4px;
			width:100%;
			background-color:#436B5C;
		}
		.centerContent{
			margin-left:auto;
			margin-right:auto;
			text-align: center;
		}
		#results{
			margin-left:auto;
			margin-right:auto;
			text-align: center;
		}
	</style>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="../DOC/MyStyles.css">
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
</head>

<body style="background-color:grey">
	<table class="titleTable">
		<tr>
			<td>
				<h1 class="titleText">Digital Otter Center Main Menu MOCKUP</h1>
			</td>
		</tr>
	</table>
	
	<table class="mainTable" style="height: 100%">
		<tr style="height: 100%">
			<td rowspan=2 style="width:50%;height:100%" valign="top">
				<table class="outlineTable" style="height:100%">
					<tr style="height:100%">
						<td style="height:100%">
							<div id="mainButtons">
								<button id="newTicketForm" class="brownButton" style="width:100%">Create new ticket</button><br/><br/>
								<button id="getRecent" class="brownButton" style="width:100%">View all recent tickets</button><br/><br/>
								<button id="startSearch" class="brownButton" style="width:100%">Search tickets</button><br/><br/>
								<button id="clear" class="brownButton" style="width:100%">Clear Results</button><br/><br/>
								<button id="timeReport" class="brownButton" style="width:100%">View Timesheet</button><br/><br/>
								<button id="printTimeReport" class="brownButton" style="width:100%">Save Timesheet</button>
							</div>
							<div id="back">
								<button id="backButton" class="brownButton" style="width:100%">Back to Main Menu</button>
							</div>
							<br/>
							<div id="content" style="overflow:hidden;overflow-y:scroll;">
								
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td style="width:50%">
				<table class="outlineTable">
					<tr>
						<td style="font-family: Verdana;width:30%;text-align:left;color:#002544">
							<strong>Signed in as:</strong>
						</td>
						<td style="text-align:right;font-family: Verdana;width:70%;color:#002544">
							<strong><?php echo $_SESSION['name'] . " (" . $_SESSION['username'] . ")";?></strong>
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<hr class="navyBarHr">
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<button id="logOut" class="brownButton" style="width:100%">Click to Log Out</button>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width:50%">
				<table class="outlineTable">
					<tr>
						<td style="width:20%">
							<div class="centerContent" style="font-family: Verdana;color:#002544;"><strong>Post to BBS</strong></div>
						</td>
						<td style="width:80%">
							<textarea style="width:98%" maxlength="200" id="newBBStext"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<button id="newBBSpost" class="brownButton" style="width:100%">POST!</button>
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<hr class="navyBarHr">
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<div style="height:350px;overflow:hidden;overflow-y:scroll;" id="BBSContent">
								
							</div>
							
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=2 id="results">
				
			</td>
		</tr>
	</table>
	<script>
		setInterval("refreshBBS();",10000);
		function refreshBBS()
		{
			$.ajax(
				{
					type: "get",
					url: "../DOC/ajax/fetchBBS.php",
					success:
						function(data, status)
						{
							$("#BBSContent").html(data);
						}
				}
			);
		}
		function swapMain()
		{
			$("#content").slideToggle(500);
			$("#back").slideToggle(500);
			$("#mainButtons").slideToggle(500);
		}
		$(document).ready(function(){
			//Collapse content div 
			$("#content").slideToggle(0);
			$("#back").slideToggle(0);
			$.ajax(
				{
					type: "get",
					url: "../DOC/ajax/fetchBBS.php",
					success:
						function(data, status)
						{
							$("#BBSContent").html(data);
						}
				}
			);
		});
		
		$(document).on('focusin', '#creationDate', function(){
	     		$(this).datepicker({
						dateFormat: 'yy-mm-dd',
				        altField: ".date_alternate",
				        altFormat: "yy-mm-dd"
	
					});
	   	});
		
		$(document).on('click', 'button', function(){
				if($(this).attr('id') == "startSearch")
				{
					$.ajax(
						{
							type: "get",
							url: "../DOC/ajax/createSearchBox.php",
							success:
								function(data, status)
								{
									$("#content").html(data);
									swapMain();
								}
						}
					);
				}
				else if($(this).attr('id') == "search")
				{
					$.ajax(
						{
		            		type: "get",
		            		url: "../DOC/ajax/searchDB.php",
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
		                			swapMain();
		              			},
		              		error:
		              			function(errorThrown){
		              				console.log(errorThrown);
		              			},
		         		}
	         		);
	         	}
	         	else if($(this).attr('id') == "newBBSpost")
	         	{
	         		if($("#newBBStext").val() != "")
	         		{
	         			$.ajax(
							{
						        type: "get",
						        url: "../DOC/ajax/postToBBS.php",
						        data: {
						        	"message": $("#newBBStext").val(),
						        },
						        success: 
						        	
						        	function(data,status) {
						        		$("#newBBStext").val("");
						        		$.ajax(
											{
												type: "get",
												url: "../DOC/ajax/fetchBBS.php",
												success:
													function(data, status)
													{
														$("#BBSContent").html(data);
													}
											}
										);
						    		},
							}
					    );
	         		}
	         		
				}
				else if($(this).attr('id') == "getRecent")
				{
					var d = new Date();
					d.setDate(d.getDate()-7);
					$.ajax(
						{
		            		type: "get",
		            		url: "../DOC/ajax/searchDB.php",
		            		data: {
		            			"firstName": "",
		            			"lastName": "",
		            			"address": "",
		            			"phoneNumber": "",
		            			"email": "",
		            			"computerModel": "",
		            			"serviceRequested": "",
		            			"extraParts": "",
		            			"requestTime": d.toISOString().slice(0, 19).replace('T', ' '),
		            			"complete": "",
		            		},
		            		success: 
		            			function(data,status) {
		                			$("#results").html(data);
		              			},
		              		error:
		              			function(errorThrown){
		              				console.log(errorThrown);
		              			},
		         		}
	         		);
				}
				else if($(this).attr('id') == "clear")
				{
					//$("#mainButtons").slideToggle(500)
					$("#results").html("");
					$("#content").html("")
				}
				else if($(this).attr('id') == "logOut")
				{
					document.location.href = "../DOC/Logout.php";
				}
				else if($(this).attr('id') == "newTicketForm")
				{
					$.ajax(
						{
							type: "get",
							url: "../DOC/ajax/createNewTicketForm.php",
							success:
								function(data, status)
								{
									$("#content").html(data);
									swapMain();
								}
						}
					);
				}
				else if($(this).attr('id') == "newTicket")
				{
					$.ajax(
						{
		            		type: "get",
		            		url: "../DOC/ajax/newTicket.php",
		            		data: {
		            			"firstName": $("#nfirstName").val(),
		            			"lastName": $("#nlastName").val(),
		            			"address": $("#naddress").val(),
		            			"phoneNumber": $("#nphoneNumber").val(),
		            			"email": $("#nemail").val(),
		            			"computerModel": $("#ncomputerModel").val(),
		            			"serviceRequested": $("#nserviceRequested").val(),
		            			"extraParts": $("#nextraParts").val(),
		            		},
		            		success: 
		            			function(data,status) {
		                			$("#results").html(data);
		                			$("#nfirstName").val("");
		            				$("#nlastName").val("");
		            				$("#naddress").val("");
		            				$("#nphoneNumber").val("");
		            				$("#nemail").val("");
		            				$("#ncomputerModel").val("");
		            				$("#nserviceRequested").val("");
		            				$("#nextraParts").val("");
		            				swapMain();
		              			},
		              		error:
		              			function(errorThrown) {
		              				console.log(errorThrown);
		              			},
		         		}
	         		);
				}
				else if($(this).attr('id') == "backButton")
				{
					swapMain();
				}
				else if($(this).attr('id') == "timeReport")
				{
					$.ajax(
						{
							type: "get",
							url: "../DOC/ajax/generateTimeSheet.php",
							success:
								function(data, status)
								{
									$("#content").html(data);
									swapMain();
								}
						}
					);
				}
				else if($(this).attr('id') == "printTimeReport")
				{
					$.ajax(
						{
							type: "get",
							url: "../DOC/ajax/saveTimeSheet.php",
							success:
								function(data, status)
								{
									var hiddenElement = document.createElement('a');

									hiddenElement.href = 'data:attachment/text,' + encodeURI(data);
									hiddenElement.target = '_blank';
									hiddenElement.download = 'timesheet.csv';
									hiddenElement.click();
									//swapMain();
								}
						}
					);
				}
				else
				{
					var id = $(this).attr('data-ticketid');
					var currentButton = $(this);
					$.ajax(
						{
		            		type: "get",
		            		url: "../DOC/ajax/updateServiceTicket.php",
		            		data: {
		            		"serviceId": $(this).attr('data-ticketid'),
		            		},
		            		success: 
		            			function(data,status) {
		            				$.ajax(
		            					{
		            						type: "get",
		            						url: "../DOC/ajax/fetchTicketById.php",
		            						data: {
		            							"id": id,
		            						},
		            						success: 
		            							function(data, status) {
		            								currentButton.parent().parent().parent().parent().parent().html(data);
		            							}
		            					}
		            				);
		              			},
		         		}
	         		);
	         		//End outer AJAX
				}
			});
	</script>
</body>
