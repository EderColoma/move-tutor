<?php
/*
 * Include da biblioteca de ajax, essa biblioteca faz com que o processameto e a 
 * renderização possam ser feitos em background, desse modo não precisamos ficar 
 * recarregando a pagina.
 */
require_once($_SERVER['DOCUMENT_ROOT']."/vendor/ajax/xajax.inc.php");
require_once("app/PokemonMoveTutor.php");

/*
 * Include da biblioteca de manipulação do HTML, com isso podemos isolar o HTML do código PHP 
 */
include_once("vendor/xtemplate/xtemplate.php");

$xajax = new xajax();

function loadGames()
{

	$html = "<table class='tbl-games'>";
	
	$response = new xajaxResponse();

	foreach( Game::getList() as $k => $v )
	{
		$arr = array_values($v);
		$checkGame = new CheckBox("chkGame", "chkGame", "", $arr[0], $arr[1]);
		$checkGame->setAction("click", "loadMoves();");
		$html .= "<tr><td>".$checkGame->toHtml()."</td>";
	}

	$html .= "</table>";

	$response->addAssign("check_games", "innerHTML", utf8_encode( $html ) );
	return $response->getXML();

}

function loadMoves( $pokemon = null, $form = null, $games = null )
{

	$response = new xajaxResponse();

	$site = new PokemonMoveTutor($pokemon, $form, $games);
	assignCombosToResponse($site, $response);

	return $response->getXML();

}

function check($pokemon, $moves, $games)
{

	$response = new xajaxResponse();
	$html = "";

	if( $moves == "")
	{
	
		$html = "Select at least one move!";
		
		if( $pokemon == "" )
		{
			$html = "Select a pokemon or at least one move!";
		} 

		$response->addAssign( "select_pokemon_validation", "innerHTML", utf8_encode( $html ) );
		return $response->getXML();
		die;
		
	}

	$arrGames = explode( ",", $games );
	$arrMoves = explode( ",", $moves );
	
	$moveset = new Moveset();
	
	$moveset->setGames($arrGames);

	if(isset($arrMoves[0])) $moveset->setFirstMove(new move($arrMoves[0]));
	if(isset($arrMoves[1])) $moveset->setSecondMove(new move($arrMoves[1]));
	if(isset($arrMoves[2])) $moveset->setThirdMove(new move($arrMoves[2]));
	if(isset($arrMoves[3])) $moveset->setFourthMove(new move($arrMoves[3]));
	
	if( $pokemon != "" )
	{
		$arr = explode('-', $pokemon);
		$arrPokemon = array( array( "id_pokemon" => $arr[0], "form" => ( isset( $arr[1] ) ? $arr[1] : "" ) ) );
	}
	else
	{ 
		$arrPokemon = $moveset->findPokemons();
	}

	foreach( $arrPokemon as $k => $v )
	{
		
		$moveset->setPokemon(new Pokemon($v["id_pokemon"]));
		$moveset->setForm($v["form"]);
		$tableLearnset = new TableLearnset("","","",$moveset);
		$html .= $tableLearnset->toHtml()."<br>";

	}

	$response->addAssign( "result", "innerHTML", utf8_encode( $html ) );
	$response->addAssign( "select_pokemon_validation", "innerHTML", utf8_encode( "" ) );
	return $response->getXML();

}

function assignCombosToResponse($site, $response)
{
	$response->addAssign( 'select_first_move', 'innerHTML', utf8_encode( $site->getCboFirstMove()->toHtml() ) );
	$response->addAssign( 'select_second_move', 'innerHTML', utf8_encode( $site->getCboSecondMove()->toHtml() ) );
	$response->addAssign( 'select_third_move', 'innerHTML', utf8_encode( $site->getCboThirdMove()->toHtml() ) );
	$response->addAssign( 'select_fourth_move', 'innerHTML', utf8_encode( $site->getCboFourthMove()->toHtml() ) );
}

function loadStartPage()
{
	
	$response = new xajaxResponse();
	$site = new PokemonMoveTutor();
	
	$response->addAssign( "select_pokemon", "innerHTML", utf8_encode( $site->getCboPokemon()->toHtml() ) );
	assignCombosToResponse($site, $response);

	return $response->getXML();

}

/*
 * Faz com que o método carregarComboPokemon fique acessível através de chamada javascript. 
 */

$xajax->registerFunction( 'loadStartPage' );
$xajax->registerFunction( 'loadGames' );
$xajax->registerFunction( 'loadMoves' );
$xajax->registerFunction( 'loadPokemonMoves' );
$xajax->registerFunction( 'check' );
$xajax->processRequests();

/*
 * Renderizar o HTML 
 */
$xtpl = new XTemplate( "html/index.html" );
$xtpl->assign( "ajax", $xajax->printJavascript('vendor/ajax') );
$xtpl->parse( "Principal.Cabecalho" );	
$xtpl->parse("Principal");
$xtpl->out("Principal");
