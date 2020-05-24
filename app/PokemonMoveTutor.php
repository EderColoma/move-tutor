<?php
require_once("pokemon/Game.php");
require_once("pokemon/Pokemon.php");
require_once("pokemon/Moveset.php");
require_once("pokemon/Move.php");
require_once("html/CheckBox.php");
require_once("html/Select.php");
require_once("html/TableLearnset.php");

class PokemonMoveTutor
{
	
	private $cboPokemon;
	private $cboFirstMove;
	private $cboSecondMove;
	private $cboThirdMove;
	private $cboFourthMove;

	function __construct( $pokemon = null, $form = null, $games = null )
	{
		$this->setCboPokemon();
		$this->setCboMoves($pokemon, $form, $games);
	}

	public function setCboPokemon( $id_game = null )
	{
		$this->cboPokemon = new Select("cboPokemon", "cboPokemon", "Pokemon", null, "selects");
		$this->cboPokemon->setNullOption(0, "-- Select Pokémon --");
		$this->cboPokemon->setAction("change", "loadMoves();");
	}

	public function getCboPokemon()
	{
		return $this->cboPokemon;
	}

	public function setCboMoves( $pokemon, $form, $games )
	{

		$this->setCboFirstMove($pokemon, $form, $games);
		$this->setCboSecondMove($pokemon, $form, $games);
		$this->setCboThirdMove($pokemon, $form, $games);
		$this->setCboFourthMove($pokemon, $form, $games);

	}

	private function setCboFirstMove($pokemon, $form, $games)
	{
		$cboMove = new Select("cboFirstMove", "cboFirstMove", "Move", $this->createMoveConditionsArray($pokemon, $form, $games), "selects" );
		$cboMove->setNullOption(0, "-- Select Move --");
		$this->cboFirstMove = $cboMove;
	}
	
	public function getCboFirstMove()
	{
		return $this->cboFirstMove;		
	}
	
	private function setCboSecondMove($pokemon, $form, $games)
	{
		
		$cboMove = new Select("cboSecondMove", "cboSecondMove", "Move", $this->createMoveConditionsArray($pokemon, $form, $games), "selects" );
		$cboMove->setNullOption(0, "-- Select Move --");
		$this->cboSecondMove = $cboMove;		
	}
	
	public function getCboSecondMove()
	{
		return $this->cboSecondMove;	
	}
	
	private function setCboThirdMove($pokemon, $form, $games)
	{
		$cboMove = new Select("cboThirdMove", "cboThirdMove", "Move", $this->createMoveConditionsArray($pokemon, $form, $games), "selects" );
		$cboMove->setNullOption(0, "-- Select Move --");
		$this->cboThirdMove = $cboMove;
	}
	
	public function getCboThirdMove()
	{
		return $this->cboThirdMove;	
	}
	
	private function setCboFourthMove($pokemon, $form, $games)
	{
		$cboMove = new Select("cboFourthMove", "cboFourthMove", "Move", $this->createMoveConditionsArray($pokemon, $form, $games), "selects" );
		$cboMove->setNullOption(0, "-- Select Move --");
		$this->cboFourthMove = $cboMove;
	}
	
	public function getCboFourthMove()
	{
		return $this->cboFourthMove;	
	}
	
	private function createMoveConditionsArray( $pokemon = null, $form = null, $games = null )
	{
		
		$arr = array();
		if( isSet( $pokemon ) && $pokemon != 'undefined' && $pokemon > 0 ) $arr['Pokemon'] = $pokemon;
		if( isSet( $form ) && $form != 'undefined' ) $arr['Form'] = $form;
		if( isSet( $games ) && $games != 'undefined' && $games != '' ) $arr['Games'] = explode(",", $games );
		
		return ( count($arr) == 0 ? null : $arr );
		
	}

}