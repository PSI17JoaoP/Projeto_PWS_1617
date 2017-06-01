<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class GameController extends BaseController
{

	public function index(){
		Session::set('bet', 0);
		Session::remove('hand');
		Session::remove('deck');


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
		Session::set('bet', $bet);

		$user_session = Session::get('user');

		if ($user_session->saldo_atual >= $bet) {
			
			$user_session->saldo_atual -= $bet;
			$user_session->save();

			$move = new Movement();
			$move->tipo = "bet";
			$move->descricao = "Aposta x$bet";
			$move->valor = $bet;
			$move->saldo = $user_session->saldo_atual;
			$move->idutilizador = $user_session->id;
			$move->save();

			$game = new Game();

			$deck = $game->CreateDeck();
			$hand = $game->CreateHand($deck);

			Session::set('hand', $hand);
			Session::set('deck', $deck);

			$handImages = array();

			foreach ($hand as $handCard) {
				array_push($handImages, $handCard->Image);
			}


			View::attachsubview('gamehand', 'game.hand', ['hand' => $handImages, 'title' => 'Mão Inicial']);
			View::attachsubview('gamebody', 'game.hold');

			return View::make('game.index');
		}else{

			Redirect::ToRoute('game/index');
		}

				

	}

	public function finish(){
		$card1 = Post::get('c0');
		$card2 = Post::get('c1');
		$card3 = Post::get('c2');
		$card4 = Post::get('c3');
		$card5 = Post::get('c4');
		
		$user_session = Session::get('user');

		$game = new Game();

		$hand = $game->DrawHand(Session::get('deck'), Session::get('hand'), $card1, $card2, $card3, $card4, $card5);

		//---------------------------------------------
		$handImages = array();

		foreach ($hand as $handCard) {
			array_push($handImages, $handCard->Image);
		}
		//---------------------------------------------

		$prize = $game->CheckHand($hand);

		$reward = $game->CheckPrize($prize, Session::get('bet'));

		$user_session->saldo_atual += $reward;
		$user_session->save();

		if ($prize != "Nothing") {
			$move = new Movement();
			$move->tipo = "win";
			$move->descricao = $prize;
			$move->valor = $reward;
			$move->saldo = $user_session->saldo_atual;
			$move->idutilizador = $user_session->id;
			$move->save();
		}

			
		View::attachsubview('gamehand', 'game.statichand', ['hand' => $handImages, 'title' => 'Mão Final']);
		View::attachsubview('gamebody', 'game.results', ['prize' => $prize, 'reward' => $reward]);

		return View::make('game.index');
	}

}