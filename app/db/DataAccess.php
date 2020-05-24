<?php
class DataAccess
{
	
	public function getDatabaseConnection()
	{

	    $link = mysqli_connect('mysql.hostinger.es', 'u262963513_tutor', 'TemosQuePegar150', 'u262963513_tutor');
	    //$link = mysqli_connect('localhost', 'root', '@emcdkv4833', 'u802852207_mvtutor');
	    //$link = mysqli_connect('mysql.hostinger.com.br', 'u794738600_tutor', 'TemosQuePegar150', 'u794738600_tutor');
	    
	    return $link;
	    
	}
	
	public function closeDatabaseConnection($link)
	{
		mysqli_close($link);		
	}

}
?>