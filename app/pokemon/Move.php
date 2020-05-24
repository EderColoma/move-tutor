<?php
require_once("app/db/Query.php");
require_once("app/general/Listable.php");

class Move implements Listable
{
	
	private $idMove;
	private $name;

	public function __construct($idMove)
	{
		$this->setIdMove($idMove);
		$this->loadMove();
	}

	public function setIdMove($idMove)
	{
		$this->idMove = $idMove;		
	}

	public function getIdMove()
	{
		return $this->idMove;		
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
	
	private function loadMove()
	{

		$query = "SELECT name
				  FROM pm_move
				  WHERE id_move = ".$this->idMove;

		$rs = Query::executeQuery($query);

		$this->setName($rs[0]["name"]);

	}

	/*
	 * Implementação do método especificado pela interface Listable.
	 */
	public static function getList(array $conditions = null)
	{
		
		if( count($conditions) > 0 )
		{
			$query = "SELECT distinct m.id_move,
								  	  m.name
				  FROM rl_pokemon_move_game pmg,
					   pm_move m
				  WHERE pmg.id_move = m.id_move";
		
			if( isSet( $conditions['Pokemon'] ) )
			{
				
				$query .= " AND ( pmg.id_pokemon IN ( SELECT id_pokemon
						    								 FROM pm_pokemon
						    								 WHERE id_evolution IN ( SELECT id_evolution
												    								 FROM pm_pokemon
												    								 WHERE id_pokemon = ".$conditions['Pokemon']." )
												    								 AND evolution_sequence < ( SELECT evolution_sequence
																			   									FROM pm_pokemon
																			   									WHERE id_pokemon = ".$conditions['Pokemon']." )  ) OR pmg.id_pokemon = ".$conditions['Pokemon']." )";
				
				/*$query .= " AND pmg.id_pokemon = ".$conditions['Pokemon'];*/
	
			}
			
			if( isSet( $conditions['Form'] ) )
			{
				
				 $query .= " AND ( pmg.form = '".$conditions['Form']."' OR pmg.form IS NULL )";
				
			}
	
			if( isSet( $conditions['Games'] ) )
			{
				$query .= " AND pmg.id_game IN ( ".implode(",", $conditions['Games'])." ) ";
			}
	
		}
		else
		{
			$query = "SELECT m.id_move, 
						 	 m.name
				   FROM pm_move m";
		}

		$query .= " ORDER BY m.name";
		
		return Query::executeQuery($query);

	}

}