<?php
class DataAccess
{
	
	public function getDatabaseConnection()
	{

	    $link = mysqli_connect('us-cdbr-east-06.cleardb.net', 'heroku_24bc08400b830f5', '81e98594', 'b13e0a401ce94e');
	    
	    return $link;
	    
	}
	
	public function closeDatabaseConnection($link)
	{
		mysqli_close($link);		
	}

}
?>
