function loadGames(){ xajax_loadGames(); }

/*
 * Preenche as combos de ataques, caso um pok�mon tenha sido selecionado,
 * as combos ser�o preenchidas apenas com o ataque do pok�mon e caso, al�m do pok�mon,
 * um ou mais jogos tenham sido selecionados retorna os ataques do pok�mon naqueles jogos.
 * Se n�o for selecionado nenhum pok�mon mas houver jogos selecionados preenche a combo com 
 * os ataques dispon�veis nesses jogos.
 */
function loadMoves()
{ 
	
	if( document.getElementById("cboPokemon") != null )
	{
		
		var pokemon = document.getElementById("cboPokemon").value;
		var form = '';

		if( pokemon.indexOf("-") != -1 )
		{
	
			arr = pokemon.split("-");
			pokemon = arr[0];
			form = arr[1];
	
		}
	}

	games = getSelectedGames();

	xajax_loadMoves( pokemon,  form, games ); 


}

function getSelectedPokemon()
{

	if( document.getElementById("cboPokemon") != null )
	{
		
		if( document.getElementById("cboPokemon").value != "0" )
		{
			return document.getElementById("cboPokemon").value;
		}
		else
		{
			return "";
		}
		
	}

}

/*
 * Verifica quais os jogos selecionados e retorna uma lista com o id desses jogos,
 * caso nenhum jogo esteja selecionado, retorna o id de todos os jogos.
 */
function getSelectedGames()
{

	if( document.getElementById("chkGame") != null )
	{
		
		var arr = document.frmMoveset.chkGame;
		var gamesChecked = "";
		var gamesUnchecked = "";

		for( i = 0; i < arr.length; i++ )
		{
			if( arr[i].checked )
			{
				gamesChecked += "," + arr[i].value;
			}
			else
			{
				gamesUnchecked += "," + arr[i].value;
			}
		}

		if( gamesChecked.length == 0 )
		{
			return gamesUnchecked.substring(1);
		}
		else
		{
			return gamesChecked.substring(1);
		}
		
	}
	
}

/*
 * Verifica quais ataques foram selecionados e retorna uma lista com o id desses ataques
 */
function getSelectedMoves()
{

	var moves = "";

	/*
	 * Verfica se as combos j� foram carregadas 
	 */
	if( document.getElementById("cboFourthMove") != null )
	{

		if( document.getElementById("cboFirstMove").value > 0 )
		{
			moves += "," + document.getElementById("cboFirstMove").value;
		}
		if( document.getElementById("cboSecondMove").value > 0 )
		{
			moves += "," + document.getElementById("cboSecondMove").value;
		}
		if( document.getElementById("cboThirdMove").value > 0 )
		{
			moves += "," + document.getElementById("cboThirdMove").value;
		}
		if( document.getElementById("cboFourthMove").value > 0 )
		{
			moves += "," + document.getElementById("cboFourthMove").value;
		}
	}

	return moves.substring(1);
	
}

/*
 * Realiza o preenchimento dos dados nos controles no estado inicial da tela
 */
function load()
{
	
	loadGames();
	xajax_loadStartPage();

}

/*
 * Obt�m as informa��es de como os pok�mons aprendem os ataques
 */
function check()
{

	var games = getSelectedGames();
	var moves = getSelectedMoves();
	var pokemon = getSelectedPokemon();
	
	xajax_check(pokemon, moves, games);

}