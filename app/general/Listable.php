<?php
interface Listable
{
	
	/*
	 * Fun��o para retornar a lista de elementos que atendem a determinadas condi��es no formato chave-valor. 
	 */
	public static function getList(array $conditions = null);
	
}