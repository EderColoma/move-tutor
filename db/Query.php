<?php
require 'DataAccess.php';

class Query
{
	
	public static function executeQuery($query)
	{
	
		$conn = new DataAccess();
		$link = $conn->getDatabaseConnection();

    	$result = mysqli_query($link, $query);
    	
    	$list = array();
    	while ($row = mysqli_fetch_assoc($result))
    	{
        	$list[] = $row;
    	}
		mysqli_free_result($result);

    	$conn->closeDatabaseConnection($link);

	    return $list;

	}

}
?>