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
?>