<?php
require_once("app/db/Query.php");
require_once("app/general/Listable.php");

class Game implements Listable
{
	
	/*
	 * Implementaчуo do mщtodo especificado pela interface Listable.
	 */
	public static function getList(array $conditions = null)
	{
		
		$query = "SELECT id_game,
						 name
				  FROM pm_game
				  WHERE generation = 5";
		
		return Query::executeQuery($query);
		
	}

}