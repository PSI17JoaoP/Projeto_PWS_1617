<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;
use Tracy\Debugger;

class UserController extends BaseController
{
	public function perfil()
	{
		if(Session::has('user'))
		{
			$user = Session::get('user');

			View::attachsubview('perfil', 'user.perfil',  ['user' => $user]);

			return View::make('user/index');
		}

		else
		{
			Redirect::toRoute('home/index');
		}
	}

	public function editar()
	{
		if(Session::has('user'))
		{
			$nome = Post::get('nome');
			$birthdate = date_create(Post::get('birthdate'));
			$email = Post::get('email');
			$username = Post::get('username');
			$password = Post::get('password');

			$dirty = false;

			$user_session = Session::get('user');

			$user = User::find($user_session->id);

			if($password != "")
			{
				$user->password = password_hash($password, PASSWORD_BCRYPT);
			}

			if($user->nome_completo != $nome)
			{
				$user->nome_completo = $nome;				
			}

			if($user->data_nascimento != $birthdate)
			{
				$user->data_nascimento = $birthdate;				
			}

			if($user->email != $email)
			{
				$user->email = $email;
			}

			if($user->username != $username)
			{
				$user->username = $username;			
			}

			if($dirty)
			{
				$user->save();

				Session::destroy();
				Session::set('user', $user);

				Redirect::ToRoute('game/index');
			}
		}

		else
		{
			Redirect::toRoute('home/index');
		}
	}

	public function movimentos()
	{
		if(Session::has('user'))
		{
			$user = Session::get('user');

			$restricoes = array('conditions' => array('idutilizador = ?', $user->id));

			$movimentos = Movement::all($restricoes);

			return View::make('user/movimentos', ['movimentos' => $movimentos]);
		}

		else
		{
			Redirect::toRoute('home/index');
		}
	}

	public function carregamento()
	{
		if(Session::has('user'))
		{
			$user = Session::get('user');

			return View::make('user/carregamento', ['saldo' => $user->saldo_atual]);
		}

		else
		{
			Redirect::toRoute('home/index');
		}
	}

	public function carregar()
	{
		if(Session::has('user'))
		{
			$montante = str_replace(' ', '', Post::get('montante'));

			$user = Session::get('user');

			if(is_numeric($montante))
			{
				if($montante != "")
				{
					$creditos = (intval($montante) * 4);
					$saldo = $user->saldo_atual + $creditos;
					$user->saldo_atual = $saldo;

					$user->save();

					$movement = new Movement();
					$movement->tipo = "pay";
					$movement->descricao = "Carregamento " . $montante . "€";
					$movement->valor = $creditos;
					$movement->saldo = $user->saldo_atual;
					$movement->idutilizador = $user->id;
					
					if($movement->is_valid())
					{
						$movement->save();

						Session::destroy();
						Session::set('user', $user);

						Redirect::ToRoute('game/index');
					}

					/*else
					{
						Redirect::flashToRoute('game/index', ['movement' => $movement->errors]);
					}*/	
				}
			}
		}

		else
		{
			Redirect::toRoute('home/index');
		}		
	}

	public function logout()
	{
		if(Session::has('user'))
		{
			Session::destroy();

			Redirect::toRoute('home/index');
		}

		else
		{
			Redirect::toRoute('home/index');
		}		
	}
}

?>