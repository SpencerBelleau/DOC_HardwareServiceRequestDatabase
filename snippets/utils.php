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
			$col = "style='background-color:LightCoral'";
		}else if ($row['complete'] == 2){
			$col = "style='background-color:LimeGreen'";
		}else{
			$col = "style='background-color:Khaki'";
		}
		echo '<table ' . $col . '>';
		echo '<tr><td style="width:150px"><b>NAME:</b></td><td> ' . $row['firstName'] . " " . $row['lastName'] . '</td></tr>';
		echo '<tr><td style="width:150px"><b>ADDRESS:</b></td><td> ' . $row['address'] . '</td></tr>';
		echo '<tr><td style="width:150px"><b>PHONE:</b></td><td> ' . $row['phoneNumber'] . '</td></tr>';
		echo '<tr><td style="width:150px"><b>E-MAIL:</b></td><td> ' . $row['email'] . '</td></tr>';
		echo '<tr><td style="width:150px"><b>COMPUTER:</b></td><td> ' . $row['computerModel'] . '</td></tr>';
		echo '<tr><td style="width:150px"><b>SERVICE:</b></td><td> ' . $row['serviceRequested'] . '</td></tr>';
		echo '<tr><td colspan=2><b>EXTRA PARTS</b><br/>' . $row['extraParts'] . '</td></tr>';
		echo '<tr><td style="width:150px"><b>TIME SUBMITTED:</b></td><td> ' . $row['requestTime'] . '</td></tr>';
		if($row['complete'] == 0)
		{
			echo '<tr><form method="post"><td style="width:50%">';
			echo '<input type="hidden" name="submission" value="Open">';
			echo '<input type="hidden" value="'. $row['serviceID'] .'" name="serviceID">';
			echo '<input style="width:100%" type="submit" value="Open">';
			echo '</td></form>';
			
			echo '<form method="post"><td style="width:50%">';
			echo '<input type="hidden" name="submission" value="Complete">';
			echo '<input type="hidden" value="'. $row['serviceID'] .'" name="serviceID">';
			echo '<input style="width:100%" type="submit" value="Complete">';
			echo '</td></form></tr>';
		}else if($row['complete'] == 1){
			echo '<tr><form method="post"><td colspan=2>';
			echo '<input type="hidden" name="submission" value="Complete">';
			echo '<input type="hidden" value="'. $row['serviceID'] .'" name="serviceID">';
			echo '<input style="width:100%" type="submit" value="Complete">';
			echo '</td></form></tr>';
		}
		echo '</table>';
	}
?>