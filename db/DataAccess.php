<?php
class DataAccess
{
	
	public function getDatabaseConnection()
	{

	    //$link = mysqli_connect('localhost', 'root', '@emcdkv4833', 'u802852207_mvtutor');
	    $link = mysqli_connect('mysql.yupage.com', 'u802852207_tutor', 'TemosQuePegar150', 'u802852207_mvtutor');
	    
	    return $link;
	    
	}
	
	public function closeDatabaseConnection($link)
	{
		mysqli_close($link);		
	}

}
?>