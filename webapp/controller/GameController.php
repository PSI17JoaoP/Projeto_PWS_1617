<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class GameController extends BaseController
{

	public function index(){
		$_SESSION["bet"] = 0;

		$handImages = array();

		for($i=0; $i<5; $i++) {
			array_push($handImages, "cardBack_blue5.png");
		}

		View::attachsubview('gamehand', 'game.staticHand',  ['hand' => $handImages, 'title' => 'Jogue!']);
		View::attachsubview('gamebody', 'game.bet');

		return View::make('game.index');
	}

	public function start(){

		$bet = Post::get('bet');
		$_SESSION["bet"] = $bet;


		$game = new Game();

		$deck = $game->CreateDeck();
		$hand = $game->CreateHand($deck);

		$_SESSION["hand"] = $hand;
		$_SESSION["deck"] = $deck;


		$handImages = array();

		foreach ($hand as $handCard) {
			array_push($handImages, $handCard->Image);
		}


		View::attachsubview('gamehand', 'game.hand', ['hand' => $handImages, 'title' => 'Mão Inicial']);
		View::attachsubview('gamebody', 'game.hold');

		return View::make('game.index');

	}

	public function finish(){
		$card1 = Post::get('c0');
		$card2 = Post::get('c1');
		$card3 = Post::get('c2');
		$card4 = Post::get('c3');
		$card5 = Post::get('c4');
	

		$game = new Game();

		$hand = $game->DrawHand($_SESSION["deck"], $_SESSION["hand"], $card1, $card2, $card3, $card4, $card5);

		//---------------------------------------------
		$handImages = array();

		foreach ($hand as $handCard) {
			array_push($handImages, $handCard->Image);
		}
		//---------------------------------------------

		$prize = $game->CheckHand($hand);

		$reward = $game->CheckPrize($prize, $_SESSION["bet"]);

			
		View::attachsubview('gamehand', 'game.statichand', ['hand' => $handImages, 'title' => 'Mão Final']);
		View::attachsubview('gamebody', 'game.results', ['prize' => $prize, 'reward' => $reward]);

		return View::make('game.index');
	}

}