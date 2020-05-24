<?php
interface Listable
{
	
	/*
	 * Funчуo para retornar a lista de elementos que atendem a determinadas condiчѕes no formato chave-valor. 
	 */
	public static function getList(array $conditions = null);
	
}