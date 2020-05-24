<?php
require_once("app/db/Query.php");
require_once("app/general/Listable.php");

class Pokemon implements Listable
{

	private $idPokemon;
	private $name;
	private $idEvolution;
	private $evolutionSequence;

	function __construct($idPokemon)
	{
		$this->setIdPokemon($idPokemon);
		$this->loadPokemon();	
	}

	public function setIdPokemon($idPokemon)
	{
		$this->idPokemon = $idPokemon;
	}
	
	public function getIdPokemon()
	{
		return $this->idPokemon;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	} 

	private function setIdEvolution($idEvolution)
	{
		$this->idEvolution = $idEvolution;
	}

	public function getIdEvolution()
	{
		return $this->idEvolution;
	}
	
	private function setEvolutionSequence($evolutionSequence)
	{
		$this->evolutionSequence = $evolutionSequence;
	}

	public function getEvolutionSequence()
	{
		return $this->evolutionSequence;
	}
	
	private function loadPokemon()
	{

		$query = "SELECT name,
						 IFNULL(evolution_sequence,0) evolution_sequence,
						 IFNULL(id_evolution,0) id_evolution
				  FROM pm_pokemon
				  WHERE id_pokemon = ".$this->idPokemon;

		$rs = Query::executeQuery($query);

		$this->setName($rs[0]["name"]);
		$this->setIdEvolution($rs[0]["id_evolution"]);
		$this->setEvolutionSequence($rs[0]["evolution_sequence"]);

	}
	
	/*
	 * Implementação do método especificado pela interface Listable.
	 */
	public static function getList(array $conditions = null)
	{
	
		$query = "SELECT DISTINCT ( CASE WHEN r.form IS NULL THEN
									    p.id_pokemon
								    ELSE
									    concat( p.id_pokemon, '-', r.form)
								    END ) id,
								  ( CASE WHEN r.form IS NULL THEN
									    concat( lpad(p.id_pokemon,3,'0'), ' - ' , p.name )
								    ELSE
									    concat( concat( lpad(p.id_pokemon,3,'0'), ' - ' , p.name ) , ' - ', r.form)
								    END ) name
				  FROM pm_pokemon p,
					   rl_pokemon_move_game r
				  WHERE p.id_pokemon = r.id_pokemon ";

		/*
		if( isset($game) )
		{
			$query .= "";
		}
		else
		{
			$query .= "";
		}
		*/

		$query .= "ORDER BY p.id_pokemon, 
							r.form";

		return Query::executeQuery($query);

	}

}