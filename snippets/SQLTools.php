<?php
	//Runs a SQL command, returns a table
	//Limitations: Does not prevent injection (sanitize before passing)
    function executeSQL($command, $dbConn)
	{
		$prep = $dbConn -> prepare($command);
		$prep -> execute();
		$ret = $prep -> fetchAll(PDO::FETCH_ASSOC);
		return $ret;
	}
	function executeSQL_U($command, $dbConn) //Does not return a table, used for executing anything but SELECT
	{
		$prep = $dbConn -> prepare($command);
		$prep -> execute();
	}
	
	//Use arg format (command, dbConn, ":word", "replacement", ":word", "replacement"...)
	//For as many as needed
	function executeSQL_Safe()
	{
		$args = func_get_args();
		$prep = $args[1] -> prepare($args[0]); //args[1] will ALWAYS be $dbConn, $args[0] will ALWAYS be a command
		$antiInject = array(); //Initialize the injection protection array
		for($i=2;$i<=func_num_args()-1;$i+=2)//loop through each pair of args
		{
			$antiInject[$args[$i]] = $args[$i+1];//construct the anti-injection array
			/*
			 * array is usually formed as 
			 * array(
			 * ":thing", "realthing",
			 * ":thing2", "realthing2")
			 * etc.
			 * This uses the same internal format but creates it automatically
			 */
		}
		$prep -> execute($antiInject); //execute using the anti-injection array
		$ret = $prep -> fetchAll(PDO::FETCH_ASSOC);//get all table stuff, associative pairs only
		return $ret; //Return your table
	}
	function executeSQL_Safe_U() //This is the same as the above, but without a return, used for DELETE, INSERT and CHANGE
	{
		$args = func_get_args();
		$prep = $args[1] -> prepare($args[0]);
		$antiInject = array();
		for($i=2;$i<=func_num_args()-1;$i+=2)
		{
			$antiInject[$args[$i]] = $args[$i+1];
		}
		$prep -> execute($antiInject);
	}
	//Basic function for displaying info fetched from a SQL database in a table
	//Limitations: Must not actually have duplicate entries, must have consistent row numbers
	function SQLTable($fetched, $titles)
	{
		echo "<table border=1><tr>";
		foreach($titles as $title)
		{
			echo "<td><b>$title</b></td>";
		}
		echo "</tr>";
		foreach($fetched as $row)
		{
			//$row = array_unique($row); //Remove any duplicates, which exist for some reason
			echo "<tr>";
			foreach($row as $element)
			{
				echo "<td>$element</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
	//This is just to save time, very finicky though.
	function checkPost($post)
	{
		if(isset($post) && !empty($post))
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
?>