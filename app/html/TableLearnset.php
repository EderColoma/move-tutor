<?php
require_once("HtmlElement.php");
class TableLearnset extends HtmlElement
{
	
	private $moveset;

	public function __construct($id, $name, $cssClass, $moveset)
	{
		$this->setId($id);
		$this->setName($name);
		$this->setCssClass($cssClass);
		$this->setMoveset($moveset);	
	}
	
	public function setMoveset($moveset)
	{
		$this->moveset = $moveset;
	}

	private function writeQueryDetais($move)
	{
				
		$sql = "SELECT g.name game,
					   m.name,
					   p.name pokemon,
					   p.id_pokemon,
					   r.level,
					   r.obs,
					   t.type,
					   t.difficulty
				FROM rl_pokemon_move_game r,
					 pm_move m,
					 pm_move_type t,
					 pm_pokemon p,
					 pm_game g
				WHERE r.id_move = m.id_move
				AND r.id_game = g.id_game
				AND r.id_move_type = t.id_move_type
				AND r.id_pokemon = p.id_pokemon
				AND r.id_pokemon IN (SELECT id_pokemon 
									 FROM pm_pokemon  
									 WHERE IFNULL(id_evolution,0) = ".$this->moveset->getPokemon()->getIdEvolution()." 
									 AND ( IFNULL(evolution_sequence,0) < ".$this->moveset->getPokemon()->getEvolutionSequence()." OR id_pokemon = ".$this->moveset->getPokemon()->getIdPokemon()." ) ) 
				AND r.id_game IN (".implode(",", $this->moveset->getGames()).")
				AND r.id_move = ".$move->getIdMove()."
				AND IFNULL( r.form, 'NONE' ) = '".( $this->moveset->getForm() == '' ? 'NONE' : $this->moveset->getForm() )."' 
				ORDER BY t.difficulty,
					     p.evolution_sequence,
						 r.id_game,
						 r.level";

		return $sql; 		

	}
	
	private function getDetails($move)
	{

		$str = "<table width='100%' bgcolor='#FFFFFF' cellspacing='0'>";

		$rs = Query::executeQuery( $this->writeQueryDetais($move) );
		
		foreach($rs as $k => $v)
		{
			
			$css = ( $k % 2 == 0 ? "move-detail-even" : "move-detail-odd" );
			
			$str .= "<tr>";
			$str .= "<td width='10%' class='".$css."'>";
			$str .= $v['game'];
			$str .= "</td>";
			$str .= "<td width='90%' class='".$css."'>";
			$str .= "Learn by ".$v['type'];
			$str .= ( $v['level'] != "" ? " at level ".$v['level'] : "" );
			$str .= ( $v['id_pokemon'] != $this->moveset->getPokemon()->getIdPokemon() ? " (".$v['pokemon'].")" : "" );
			$str .= ( $v['obs'] != "" ? " (".$v['obs'].")" : "" );
			$str .= "</td>";
			$str .= "</tr>";
		}
		
		$str .= "<tr><td heigt='1px' bgcolor='#C5DAFA' colspan='2'></td></tr>";
		$str .= "</table>";

		return $str;

	}
	
	public function toHtml()
	{
		
		$html = "<table border='0' width='100%' bgcolor='#C5DAFA' cellspacing='2' cellpadding='0'>";
		$html .= "<tr>";
		$html .= "<td class='pokemon-image'>";
		$html .= "<img src='/web/images/pokemon/small/".str_pad($this->moveset->getPokemon()->getIdPokemon(), 3, '0', STR_PAD_LEFT);
		if( $this->moveset->getForm() != "" ) $html .= "-".$this->moveset->getForm();
		$html .= ".png'></img>&nbsp;";
		$html.= "</td>";
		$html .= "<td class='pokemon-header'>";
		$html .= str_pad($this->moveset->getPokemon()->getIdPokemon(), 3, '0', STR_PAD_LEFT)." - ".$this->moveset->getPokemon()->getName();
		if( $this->moveset->getForm() != "" ) $html .= "&nbsp;".$this->moveset->getForm();
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td class='move-header' colspan='2'>";
		if($this->moveset->getFirstMove())
		{
			$html .= $this->moveset->getFirstMove()->getName();
			$html .= $this->getDetails($this->moveset->getFirstMove());	
		}

		if($this->moveset->getSecondMove())
		{
			$html .= $this->moveset->getSecondMove()->getName();
			$html .= $this->getDetails($this->moveset->getSecondMove());
		}
		
		if($this->moveset->getThirdMove())
		{
			$html .= $this->moveset->getThirdMove()->getName();
			$html .= $this->getDetails($this->moveset->getThirdMove());
		}

		if($this->moveset->getFourthMove())
		{
			$html .= $this->moveset->getFourthMove()->getName();
			$html .= $this->getDetails($this->moveset->getFourthMove());
		}

		$html .= "</td>";
		$html .= "</tr>";
		$html .= "</table>";

		return $html;

	}
	
}