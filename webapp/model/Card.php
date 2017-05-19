<?php

class Card
{
	public $Naipe;
	public $Valor;
	public $Image;

	public function __construct($naipe, $valor)
	{
		
		$this->Naipe = $naipe;
		$this->Valor = $valor;
		$this->Image = "card".$naipe."".$valor.".png";
	}
}

?>