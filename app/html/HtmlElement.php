<?php
abstract class HtmlElement
{

	protected $id;
	protected $name;
	protected $cssClass;
	
	function __construct($id, $name, $cssClass = "")
	{
		$this->setId($id);
		$this->setName($name);
		$this->setCssClass($cssClass);		
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}

	public function setName($name)
	{
		$this->name = $name;		
	}
	
	public function setCssClass($cssClass)
	{
		$this->cssClass = $cssClass;		
	}
	
	public abstract function toHtml();
	
}