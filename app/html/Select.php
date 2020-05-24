<?php
require_once("HtmlControl.php");
class Select extends HtmlControl
{
	
	private $NullOptionId;
	private $NullOptionDesc;
	private $disabled;
	private $options = array();

	function __construct($id, $name, $class, array $condition = null, $cssClass = "", $disabled = false)
	{
		parent::__construct($id, $name, $cssClass);
		$this->setOptions($class, $condition);
		$this->setDisabled($disabled);
	}

	/*
	 * Obtém a lissa de elementos que irão compor a select.
	 * O Parâmetro $class deve ser uma classe que implementa a interface Listable 
	 */
	private function setOptions($class, $conditions = null)
	{
		eval("\$this->options = ".$class."::getList(\$conditions);");
	}

	public function setNullOption($NullOptionId, $NullOptionDesc)
	{
		$this->NullOptionId = $NullOptionId;
		$this->NullOptionDesc = $NullOptionDesc;
	}

	public function setDisabled($disabled)
	{
		$this->disabled = $disabled;
	}
	
	/*
	 * Gera, através das propriedades do objeto, o código html de uma select.
	 */
	public function toHtml()
	{
		$html = "<select ".($this->disabled ? "disabled" : "")." id='".$this->id."' name='".$this->name."' class='".$this->cssClass."'";
		
		if( isSet( $this->action ) )
		{
			$html .= " ".$this->action;
		}
		
		$html .= ">";

		if( isSet( $this->NullOptionId ) )
		{
			$html .= "<option value='".$this->NullOptionId."' selected>".$this->NullOptionDesc."</option>";
		}
		
		foreach( $this->options as $k => $v )
		{
			
			$arr = array_values($v);
			$html .= "<option value='".$arr[0]."'>".$arr[1]."</option>";
			
		}
		
		$html .= "</select>";
		return $html;
	}

}