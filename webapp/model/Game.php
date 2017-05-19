<?php

/*
 * Preparação do jogo
 *	Baralho
 *	Mão Inicial
 *	Nova Mão
 */

class Game
{

	function CreateDeck()
	{

		$naipeList = array("Clubs", "Diamonds", "Hearts", "Spades");
		$valorList = array("2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A");

		$deck = array();

		//---------------------------------------------------

		foreach ($naipeList as $naipe) {
			
			foreach ($valorList as $valor) {
				
				$card = new Card($naipe, $valor);

				array_push($deck, $card);
			}
		}

		shuffle($deck);

		//---------------------------------------------------

		return $deck;
	}

	function CreateHand($deck)
	{
		$hand = array();

		//---------------------------------------------------

		for ($i=0; $i < 5; $i++) { 
			array_push($hand, $deck[$i]);
		}

		//---------------------------------------------------

		return $hand;
	}

	function DrawHand($deck, $hand, $card1, $card2, $card3, $card4, $card5)
	{
		$newhand = array();
		$draw = array($card1, $card2, $card3, $card4, $card5);
		$nextCard = 0;

		//---------------------------------------------------

		foreach ($hand as $index => $card) {
			
			if ($draw[$index] == 1) {											//Trocar
				array_push($newhand, $deck[5 + $nextCard]);
				$nextCard ++;
			}else{																//Manter
				array_push($newhand, $hand[$index]);
			}
		}

		//---------------------------------------------------

		return $newhand;
	}


	/*
	 * Verificação de prémio
	 *
	 *REGRAS
	 *
	 *	X	Royal Flush      -> 5 cartas seguidas do mesmo naipe até ao 'A'
	 *	X	Straight Flush   -> 5 cartas seguidas do mesmo naipe sem o 'A'
	 *	X	4 of a Kind      -> 4 cartas iguais 
	 *  X  	Full House	     -> 3 cartas iguais + 2 cartas iguais
	 * 	X	Flush            -> 5 cartas do mesmo naipe
	 * 	X	Straight 	     -> 5 cartas seguidas
	 *	X	3 of a Kind      -> 3 cartas iguais
	 *	X	Two Pair 	  	 -> 2 pares de cartas iguais
	 *	X	Jacks or Better  -> 2 cartas iguais (J para cima)
	 */

	function CheckHand($hand)
	{
		$handNaipe = array();
		$handValor = array();

		$nNaipes = 0;

		$prize = "";
		//---------------------------------------------------

		foreach ($hand as $card) {
			array_push($handNaipe, $card->Naipe);
			array_push($handValor, $card->Valor);
		}

		$nNaipes = $this->CountNaipe($handNaipe);

		//-------------------

		if ($nNaipes == 1) { 												//Royal Flush; Straight Flush; Flush
			
			if ($this->CheckStraight($handValor)) { 								//Royal Flush; Straight Flush
				
				if (in_array("A", $handValor)) { 							//Royal Flush
					$prize = "Royal Flush";
				}else{														//Straight Flush
					$prize = "Straight Flush";
				}

			}else{															//Flush
				$prize = "Flush";
			}

		}else{					
			
			if ($this->CheckStraight($handValor)) {								//Straight
				$prize = "Straight";
			}else{

				$nValor = $this->CountValor($handValor);
				$countNValor = array_count_values($handValor);

				foreach ($countNValor as $valor => $qtd) {
					
					if ($nValor == 2) {										//4 of a Kind; Full House

						if ($qtd == 4) {									//4 of a Kind
							$prize = "4 of a Kind";						
							break;					
						}else{												//Ful House
							$prize = "Full House";						
							break;
						}				
						
					}elseif ($nValor == 3) {								//3 of a Kind; Two Pair
						
						if ($qtd == 3) {									//3 of a Kind
							$prize = "3 of a Kind";
							break;
						}else{												//Two Pair
							$prize = "Two Pair";
							break;	
						}

					}elseif ($nValor == 4){
						
						if($qtd == 2 && $this->CheckJacksorBetter($valor)) { 		//Jacks or Better 
							$prize = "Jacks or Better";	
							break;
						}else{
							$prize = "Nothing";								//Nothing
						}

					}else{													//Nothing
						$prize = "Nothing";
						break;
					}

				}


			}
		}

		//---------------------------------------------------

		return $prize;
	}

	function CountNaipe($naipeList) //Mesmo naipe
	{
		return count(array_unique($naipeList));
	}

	function CountValor($valorList) //Mesmo valor
	{
		return  count(array_unique($valorList));
	}

	function CheckStraight($valorList) //Seguidas
	{
		$listNaipe = array("2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A");
		$straight = false;

		//---------------------------------------------------

		for ($i=0; $i < 7; $i++) { 
			$slice = array_slice($listNaipe, $i, 5);

			//Verifica se as 5 cartas da mão correspondem ás 5 cartas da "slice"
			if (count(array_intersect($slice, $valorList)) == 5) { 
				$straight = true;
				break;
			}
		}

		//---------------------------------------------------

		return $straight;
	}

	function CheckJacksorBetter($valor) //Igual/Maior que J
	{
		$jorB = array('J', 'Q', 'K', 'A');
		$check = false;

		//---------------------------------------------------

		if (in_array($valor, $jorB)) {
			$check = true;
		}

		//---------------------------------------------------

		return $check;
	}

	function CheckPrize($prize, $bet){

		$reward = 0;

		if ($prize == "Royal Flush") {
				
				if ($bet == 5) {
					$reward = 4000;
				}else{
					$reward = 250*$bet;
				}

		}elseif ($prize == "Straight Flush") {
			
			$reward = 50*$bet;

		}elseif ($prize == "4 of a Kind") {
			
			$reward = 30*$bet;

		}elseif ($prize == "Full House") {
			
			$reward = 6*$bet;

		}elseif ($prize == "Flush") {
			
			$reward = 5*$bet;

		}elseif ($prize == "Straight") {
			
			$reward = 4*$bet;

		}elseif ($prize == "3 of a Kind") {
			
			$reward = 3*$bet;

		}elseif ($prize == "Two Pair") {
			
			$reward = 2*$bet;

		}elseif ($prize == "Jacks or Better") {
			
			$reward = $bet;

		}else{

			$reward = 0;

		}

		return $reward;
	}

}

?>