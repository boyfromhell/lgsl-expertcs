<?php



//Prevent direct access
if (!defined('LICENSE'))
{
	exit('Access Denied');
}


	function query_basic($query)
	{
		$result = mysql_query($query);
		if ($result == FALSE)
		{
			$msg = "\r\n<br /><b>Invalid query</b> : ".mysql_error()."\n";
			echo $msg;
		}
	}



?>