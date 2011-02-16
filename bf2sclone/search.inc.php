<?php

function getSearchResults($SEARCHVALUE)
{
	include('./queries/getPIDList.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());	
	$data = array();
	
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$data[$idx] = $row;
		$idx++;
	}	 	
	mysql_free_result($result);
	return $data;
}
?>