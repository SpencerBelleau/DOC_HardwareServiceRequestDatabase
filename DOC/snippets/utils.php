<?php
	function checkSet($var)
	{
		if (isset($var) && !empty($var))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function shortHash($input, $length)
	{
		$t = sha1($input);
		return substr($t, 0, $length);
	}
	
	function drawTicket($row)
	{
		if($row['complete'] == 0)
		{
			//$col = "style='background-color:#e64a4a'";
			$col = "class='ticketTableRed' style='display: inline-block;'";
		}else if ($row['complete'] == 2){
			//$col = "style='background-color:#52CD52'";
			$col = "class='ticketTableYellow' style='display: inline-block;'";
		}else{
			//$col = "style='background-color:#ffff77'";
			$col = "class='ticketTableGreen' style='display: inline-block;'";
		}
		echo '<table ' . $col . '>';
		echo '<tr><td style="width:175px"><b>NAME:</b></td><td style="width:325px"> ' . $row['firstName'] . " " . $row['lastName'] . '</td></tr>';
		echo '<tr><td style="width:175px"><b>ADDRESS:</b></td><td style="width:325px"> ' . $row['address'] . '</td></tr>';
		echo '<tr><td style="width:175px"><b>PHONE:</b></td><td style="width:325px"> ' . $row['phoneNumber'] . '</td></tr>';
		echo '<tr><td style="width:175px"><b>E-MAIL:</b></td><td style="width:325px"> ' . $row['email'] . '</td></tr>';
		echo '<tr><td style="width:175px"><b>COMPUTER:</b></td><td style="width:325px"> ' . $row['computerModel'] . '</td></tr>';
		echo '<tr><td colspan=2 style="width:450px"><hr class="blackBarHr"><td></tr>';
		echo '<tr><td colspan=2 style="width:450px"><b>SERVICE</b><br/> ' . $row['serviceRequested'] . '</td></tr>';
		echo '<tr><td colspan=2 style="width:450px"><b>EXTRA PARTS</b><br/>' . $row['extraParts'] . '</td></tr>';
		echo '<tr><td style="width:175px"><b>SUBMITTED:</b></td><td style="width:325px"> ' . $row['requestTime'] . '</td></tr>';
		echo '<tr><td style="width:175px"><b>OPENED:</b></td><td style="width:325px"> ' . $row['openTime'] . '</td></tr>';
		echo '<tr><td style="width:175px"><b>COMPLETED:</b></td><td style="width:325px"> ' . $row['closeTime'] . '</td></tr>';
		echo '<tr><td colspan=2 style="width:450px"><hr class="blackBarHr"><td></tr>';
		echo '<tr><td style="width:175px"><b>CREATED BY:</b></td><td style="width:325px"> ' . $row['CreatorF'] . " " . $row['CreatorL'] . '</td></tr>';
		echo '<tr><td style="width:175px"><b>OPENED BY:</b></td><td style="width:325px"> ' . $row['OpenerF'] . " " . $row['OpenerL'] . '</td></tr>';
		echo '<tr><td style="width:175px"><b>COMPLETED BY:</b></td><td style="width:325px"> ' . $row['CloserF'] . " " . $row['CloserL'] . '</td></tr>';
		if($row['complete'] == 0)
		{
			echo '<tr><form method="post"><td colspan=2>';
			echo '<input type="hidden" name="submission" value="Open">';
			echo '<input type="hidden" value="'. $row['serviceID'] .'" name="serviceID">';
			echo '<button class="greyButton" data-ticketid="'. $row['serviceID'] .'" style="width:100%">Open</button>';
			echo '</td></form>';
		}else if($row['complete'] == 1){
			echo '<tr><form method="post"><td colspan=2>';
			echo '<input type="hidden" name="submission" value="Complete">';
			echo '<input type="hidden" value="'. $row['serviceID'] .'" name="serviceID">';
			echo '<button class="greyButton" data-ticketid="'. $row['serviceID'] .'" style="width:100%">Complete</button>';
			echo '</td></form></tr>';
		}
		echo '</table>';
	}

function drawBBSMessage($row)
{
	echo '<table class="BBSmessage"><tr><td style="width:30%;border-right:1px solid black;">';
	echo "<b>" . $row['firstName'] . "<br/>" . $row['lastName'] . "</b><br/>" . $row['username'];
	echo '</td><td style="width:70%">';
	echo $row['message'] . "<br/><i>" . $row['postTime'] . "</i>";
	echo '</td></tr></table>';
}

function drawTimeIO($row)
{
	echo '<table class="';
	if($row['forgotSignout'] == 0)
	{
		echo "timeIOValid";
	}else{
		echo "timeIOInValid";
	}
	echo '"><tr><td style="border-right:1px solid black"><em>Clocked in</em><br/>';
	echo $row['timeIn'];
	echo '</td><td style="border-right:1px solid black"><em>Clocked out</em><br/>';
	echo $row['timeOut'];
	echo '</td><td><em>Total time</em><br/>';
	echo gmdate("H:i:s", $row['seconds']);
	echo '</td></tr></table>';
}
?>