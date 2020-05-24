<?php
require_once("HtmlControl.php");
class CheckBox extends HtmlControl
{
	
	private $value;
	private $text;

	function __construct($id, $name, $cssClass, $value, $text)
	{

		parent::__construct($id, $name, $cssClass);
		$this->setValue($value);
		$this->setText($text);

	}
	
	public function setValue($value)
	{

		$this->value = $value;

	}

	public function setText($text)
	{

		$this->text = $text;

	}

	/*
	 * Gera, através das propriedades do objeto, o código html de uma select.
	 */
	public function toHtml()
	{

		return "<input type='checkbox' id='".$this->id."' name='".$this->name."' class='".$this->cssClass."' value='".$this->value."' ".( isSet( $this->action) ? $this->action : '' ).">".$this->text;

	}

}