<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;


class UserController extends BaseController
{
	public function perfil()
	{
		$user = Session::get('user');

		View::attachsubview('perfil', 'user.perfil',  ['user' => $user]);

		return View::make('user/index');
	}

	public function editar()
	{
		$nome = Post::get('nome');
		$birthdate = date_create(Post::get('birthdate'));
		$email = Post::get('email');
		$username = Post::get('username');
		$password = Post::get('password');

		$dirty = false;

		$user_session = Session::get('user');

		$user = User::find($user_session->id);

		/*if(ctype_alnum($nome) && ctype_alnum($username))
		{*/
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
		/*}*/

		/*else
		{
			
		}*/
	}

	public function movimentos()
	{

		return View::make('user/movimentos');
	}

	public function carregamento()
	{
		$user = Session::get('user');

		return View::make('user/carregamento', ['saldo' => $user->saldo_atual]);
	}

	public function carregar()
	{
		$montante = str_replace(' ', '', Post::get('montante'));

		$user = Session::get('user');

		if(is_numeric($montante))
		{
			if($montante != "")
			{
				$saldo = $user->saldo_atual + (intval($montante) * 4);
				$user->saldo_atual = $saldo;
			}

			$user->save();

			Session::destroy();
			Session::set('user', $user);

			Redirect::ToRoute('game/index');
		}

		else
		{

		}
	}

	public function logout()
	{
		Session::destroy();

		Redirect::toRoute('home/index');
	}
}

?>