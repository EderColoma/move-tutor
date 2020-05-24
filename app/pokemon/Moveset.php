<?php
require_once("app/db/Query.php");

class Moveset
{
	
	private $pokemon;
	private $firstMove;
	private $secondMove;
	private $thirdMove;
	private $fourthMove;
	private $games;
	private $form;
	private $obs;

	public function setPokemon($pokemon)
	{
		
		$this->pokemon = $pokemon;
		
	}
	
	public function getPokemon()
	{
		if(isSet($this->pokemon))
		{
			return $this->pokemon;
		}
		else
		{
			return null;
		}		
	}
	
	public function setFirstMove($move)
	{
		$this->firstMove = $move;
	}
	
	public function getFirstMove()
	{
		if(isSet($this->firstMove))
		{
			return $this->firstMove;
		}
		else
		{
			return null;
		} 		
	}
	
	public function setSecondMove($move)
	{
		$this->secondMove = $move;
	}
	
	public function getSecondMove()
	{
		if(isSet($this->secondMove))
		{
			return $this->secondMove;
		}
		else
		{
			return null;
		}
	}

	public function setThirdMove($move)
	{
		$this->thirdMove = $move;
	}
	
	public function getThirdMove()
	{
		if(isSet($this->thirdMove))
		{
			return $this->thirdMove;
		}
		else
		{
			return null;
		}
	}
	
	public function setFourthMove($move)
	{
		$this->fourthMove = $move;
	}
	
	public function getFourthMove()
	{
		if(isSet($this->fourthMove))
		{
			return $this->fourthMove;
		}
		else
		{
			return null;
		}	
	}
	
	public function setGames(array $games)
	{
		$this->games = $games;
	}

	public function getGames()
	{
		return $this->games;
	}

	public function setForm($form)
	{
		$this->form = $form;
	}
	
	public function getForm()
	{
		return $this->form;
	}

	public function setObs($obs)
	{
		$this->obs = $obs;
	}
	
	public function getObs()
	{
		return $this->obs;
	}

	public function findPokemons()
	{
		
		return Query::executeQuery( $this->writeQueryPokemons() );
		
	}

	private function writeQueryPokemons()
	{

		$query = "SELECT A.id_pokemon ,
						 A.form,
						 A.obs
				  FROM ( SELECT DISTINCT p.id_pokemon,
				  						 m1.form,
				  						 m1.obs
					     FROM pm_pokemon p,
							  ( SELECT p.id_evolution,
									   p.id_pokemon,
									   p.evolution_sequence,
									   r.form,
									   r.obs
								FROM rl_pokemon_move_game r,
								     pm_pokemon p
								WHERE p.id_pokemon = r.id_pokemon
								AND r.id_move = ".$this->firstMove->getIdMove()." 
								AND r.id_game IN (".implode(",", $this->games).") ) m1
				  		 WHERE ( p.id_pokemon = m1.id_pokemon OR ( p.id_evolution = m1.id_evolution AND p.evolution_sequence > m1.evolution_sequence ) ) ) A ";
		
		if( isset($this->secondMove) )
		{
			
			$query .= ",( SELECT DISTINCT p.id_pokemon,
										  m2.form,
										  m2.obs
						  FROM pm_pokemon p,
							   ( SELECT p.id_evolution,
				 						p.id_pokemon,
				 						p.evolution_sequence,
				 						r.form,
				 						r.obs
		  						 FROM rl_pokemon_move_game r,
			   						  pm_pokemon p
		  						 WHERE r.id_move = ".$this->secondMove->getIdMove()."
		  						 AND r.id_game IN (".implode(",", $this->games).")
		  						 AND p.id_pokemon = r.id_pokemon ) m2
		  						 WHERE ( p.id_pokemon = m2.id_pokemon OR ( p.id_evolution = m2.id_evolution AND p.evolution_sequence > m2.evolution_sequence ) ) ) B ";

		}
		
		if( isset($this->thirdMove) )
		{
			
			$query .= ",( SELECT DISTINCT p.id_pokemon,
										  m2.form,
										  m2.obs
						  FROM pm_pokemon p,
							   ( SELECT p.id_evolution,
										p.id_pokemon,
										p.evolution_sequence,
										r.form,
										r.obs
								 FROM rl_pokemon_move_game r,
								   	  pm_pokemon p
								 WHERE r.id_move = ".$this->thirdMove->getIdMove()."
								 AND r.id_game IN (".implode(",", $this->games).")
								 AND p.id_pokemon = r.id_pokemon ) m2
								 WHERE ( p.id_pokemon = m2.id_pokemon OR ( p.id_evolution = m2.id_evolution AND p.evolution_sequence > m2.evolution_sequence ) ) ) C ";

		}
		
		if( isset($this->fourthMove) )
		{
			
			$query .= ", ( SELECT DISTINCT p.id_pokemon,
										   m2.form,
										   m2.obs
						   FROM pm_pokemon p,
								( SELECT p.id_evolution,
										 p.id_pokemon,
										 p.evolution_sequence,
										 r.form,
										 r.obs
							  	  FROM rl_pokemon_move_game r,
								  	   pm_pokemon p
							  	  WHERE r.id_move = ".$this->fourthMove->getIdMove()."
							  	  AND r.id_game IN (".implode(",", $this->games).")
							  	  AND p.id_pokemon = r.id_pokemon ) m2
							  	  WHERE ( p.id_pokemon = m2.id_pokemon OR ( p.id_evolution = m2.id_evolution AND p.evolution_sequence > m2.evolution_sequence ) ) ) D ";
			
		}
		
		if( isset($this->secondMove) )
		{
			$query .= " WHERE A.id_pokemon = B.id_pokemon
						AND   IFNULL( A.form, 'N') = IFNULL( B.form, 'N') ";
		}
		
		if( isset($this->thirdMove) )
		{
			
			$query .= " AND   A.id_pokemon = C.id_pokemon
						AND   B.id_pokemon = C.id_pokemon
						AND   IFNULL( A.form, 'N') = IFNULL( C.form, 'N') 
						AND   IFNULL( B.form, 'N') = IFNULL( C.form, 'N') ";
		}
		
		if( isset($this->fourthMove) )
		{
			$query .= " AND   A.id_pokemon = D.id_pokemon
						AND   B.id_pokemon = D.id_pokemon
						AND   C.id_pokemon = D.id_pokemon
						AND   IFNULL( A.form, 'N') = IFNULL( D.form, 'N') 
						AND   IFNULL( B.form, 'N') = IFNULL( D.form, 'N')
						AND   IFNULL( C.form, 'N') = IFNULL( D.form, 'N') ";
		}

		$query .= " ORDER BY A.id_pokemon,
							 A.form";

		return $query;
		
	}
	
}