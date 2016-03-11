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
			background-color:#1f346b;/*#002544;*/
			margin:auto;
			border:3px outset #0f245b;
			border-radius:4px;
			width:80%;
		}
		.titleText {
			font-family:Verdana;
			color:white;/*#A29051;*/
			text-align:center;
		}
		.mainTable{
			margin-left:auto;
			margin-right:auto;
			width:80%;
			border-collapse: separate;
			border-radius:4px;
		}
		.outlineTable{
			margin-left:auto;
			margin-right:auto;
			border:3px outset #0f245b;
			border-radius:4px;
			width:100%;
			background-color:#1f346b;/*#436B5C;/*Brighter green is #029555*/
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

<body style="background-color:#444444">
	<table class="titleTable">
		<tr>
			<td>
				<h1 class="titleText">Digital Otter Center Delegation Interface</h1>
			</td>
		</tr>
	</table>
	<br/>
	<div class="outlineTable" style="width:750px;margin-left:auto;margin-right:auto;text-align:center">
		<div>
			<div style="width:100%;padding-top:10px;vertical-align:top;margin-left:auto;margin-right:auto;text-align:center">
				<strong style="font-family: Verdana;color:white;">You are logged in as: <?php echo $_SESSION['name'] . " (" . $_SESSION['username'] . ")";?></strong><br/>
				<div style="padding-top:5px;padding-bottom:5px">
					<button id="logOut" class="brownButton" style="width:95%;margin-left:auto;margin-right:auto;text-align:center">Click to Log Out</button>
				</div>
			</div>
		</div>
		<hr style="width:80%"/>
		<div style="padding-top: 10px; padding-bottom: 10px">
			<div id="searchBox" style="width:100%;vertical-align:top;margin-left:auto;margin-right:auto;text-align:center">
				
			</div>
		</div>
		<hr style="width:80%"/>
		<div style="padding-top:10px;padding-bottom:10px">
			<div id="tickets" style="height:700px;overflow:hidden;overflow-y:scroll;">
				
			</div>
		</div>
		<hr style="width:80%"/>
		<div style="padding-top:10px;padding-bottom:10px">
			<div style="display:inline-block;width:48%">
				<button id="timeReport" class="brownButton" style="width:100%">View Timesheet</button>
			</div>
			<div style="display:inline-block;width:48%">
				<button id="printTimeReport" class="brownButton" style="width:100%">Save Timesheet</button>
			</div>
		</div>
		<div style="padding:10px" id="times">
			<button id="backButton" class="brownButton" style="width:98%">Close Report</button><br/><br/>
			<div id="content" style="height:475px;overflow:hidden;overflow-y:scroll;">
						
			</div>
		</div>
	</div>
	
	<script>
		$(document).ready(function(){
			//Collapse content div 
			$("#times").slideUp(0);
			$.ajax(
				{
					type: "get",
					url: "../DOC/ajax/createNewTicketForm.php",
					success:
						function(data, status)
						{
							$("#searchBox").html(data);
						}
				}
			);
		});
		//setInterval("refreshBBS();",10000);
		setInterval("refreshTickets();", 15000);
		setInterval("refreshTimesheet();",30000);
		function refreshTimesheet()
		{
			$.ajax(
				{
					type: "get",
					url: "../DOC/ajax/updateTimesheet.php",
					success:
						function(data, status)
						{
							//$("#BBSContent").html(data);
						}
				}
			);
		}
		/*function refreshBBS()
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
		}*/
		function refreshTickets()
		{
			if($("select:focus").length > 0)
			{
				return;
			}
			$.ajax({
				type: "get",
				url: "../DOC/ajax/fetchNew.php",
				success:
					function(data, status)
					{
						$("#tickets").html(data);
					}
			});
		}
		//refreshBBS();
		refreshTickets();
		$(document).on('click', 'button', function() {
			if($(this).attr('id') == "logOut")
			{
				document.location.href = "../DOC/Logout.php";
			}
			else if($(this).attr('id') == "timeReport")
			{
				$("#times").slideUp(500);
				$.ajax(
					{
						type: "get",
						url: "../DOC/ajax/generateTimeSheet.php",
						success:
							function(data, status)
							{
								$("#content").html(data);
								$("#times").slideDown(500);
							}
					}
				);
			}
			else if($(this).attr('id') == "backButton")
			{
				$("#times").slideUp(500, function(){
					$("#content").html("");
				});
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
								//Janky download code
								var hiddenElement = document.createElement('a');

								hiddenElement.href = 'data:attachment/text,' + encodeURI(data);
								hiddenElement.target = '_blank';
								hiddenElement.download = 'timesheet.csv';
								document.body.appendChild(hiddenElement);
								hiddenElement.click();
								document.body.removeChild(hiddenElement);
								//swapMain();
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
	            				//swapMain();
	            				refreshTickets();
	              			},
	              		error:
	              			function(errorThrown) {
	              				console.log(errorThrown);
	              			},
	         		}
         		);
			}
			else
			{
				var id = $(this).attr('data-ticketid');
				var currentButton = $(this);
				var fetch = $(this).parent().parent().parent().children().children().children('.delegateUser').val();
				var id2 = $(this).parent().parent().parent().children().children().children('.delegateUser').children(":contains('" + fetch +"')").attr("data-userid");
				var serviceText = $(this).parent().parent().parent().children().children().children().children('.serviceProvided').val();
				$.ajax(
					{
	            		type: "get",
	            		url: "../DOC/ajax/updateServiceTicket.php",
	            		data: {
	            		"serviceId": $(this).attr('data-ticketid'),
	            		"delegatedToId": id2,
	            		"service": serviceText,
	            		},
	            		success: 
	            			function(data,status) {
	            				refreshTickets();
	            				/*$.ajax(
	            					{
	            						type: "get",
	            						url: "../DOC/ajax/fetchTicketById.php",
	            						data: {
	            							"id": id,
	            							"service": serviceText,
	            						},
	            						success: 
	            							function(data, status) {
	            								currentButton.parent().parent().parent().parent().parent().html(data);
	            							}
	            					}
	            				);*/
	              			},
	         		}
	     		);
     		}
     		//End outer AJAX
		});
		/*
		setInterval("refreshTimesheet();",30000);
		function refreshTimesheet()
		{
			$.ajax(
				{
					type: "get",
					url: "../DOC/ajax/updateTimesheet.php",
					success:
						function(data, status)
						{
							//$("#BBSContent").html(data);
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
			$("#collapsibleResults").slideUp(0);
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
		            		url: "../DOC/ajax/searchDB2.php",
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
		            				swapMain();
		            				$("#collapsibleResults").slideUp(500, function(){
		            					$("#results").html(data);
		                				$("#collapsibleResults").slideDown(500);
		            				});
		                			
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
					$("#collapsibleResults").slideUp(500, function(){
						var d = new Date();
						d.setDate(d.getDate()-7);
						$.ajax(
							{
			            		type: "get",
			            		url: "../DOC/ajax/searchDB2.php",
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
			                			$("#collapsibleResults").slideDown(500);
			              			},
			              		error:
			              			function(errorThrown){
			              				console.log(errorThrown);
			              			},
			         		}
		         		);
					});
				}
				else if($(this).attr('id') == "clear")
				{
					//$("#mainButtons").slideToggle(500)
					$("#collapsibleResults").slideUp(500, function(){
						$("#results").html("");
					});
					
					$("#content").html("");
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
									//Janky download code
									var hiddenElement = document.createElement('a');

									hiddenElement.href = 'data:attachment/text,' + encodeURI(data);
									hiddenElement.target = '_blank';
									hiddenElement.download = 'timesheet.csv';
									document.body.appendChild(hiddenElement);
									hiddenElement.click();
									document.body.removeChild(hiddenElement);
									//swapMain();
								}
						}
					);
				}
				else
				{
					var id = $(this).attr('data-ticketid');
					var currentButton = $(this);
					var fetch = $(this).parent().parent().parent().children().children().children('.delegateUser').val();
					var id2 = $(this).parent().parent().parent().children().children().children('.delegateUser').children(":contains('" + fetch +"')").attr("data-userid");
					$.ajax(
						{
		            		type: "get",
		            		url: "../DOC/ajax/updateServiceTicket.php",
		            		data: {
		            		"serviceId": $(this).attr('data-ticketid'),
		            		"delegatedToId": id2,
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
			});*/
	</script>
</body>
