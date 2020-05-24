<?php
require_once("HtmlElement.php");
abstract class HtmlControl extends HtmlElement
{
	
	protected $action;
	
	public final function setAction($event, $action)
	{
		switch($event)
		{
			case "click":
				$this->action = "onClick='".$action."'";
				break;
			case "change":
				$this->action = "onChange='".$action."'";
				break;
			default:
				$this->action = "on".ucfirst($event)."='".$action."'";
		}
	}

}