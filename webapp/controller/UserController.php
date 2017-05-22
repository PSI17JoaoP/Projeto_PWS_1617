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
		//$user = User::find($id);

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

		$user_session = Session::get('user');

		$user = User::find($user_session->id);

		$dados = array();

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

		$user->save();

		Session::destroy();
		Session::set('user', $user);

		Redirect::ToRoute('game/index');
	}

	public function movimentos()
	{

		return View::make('user/movimentos');
	}

	public function carregamento()
	{

		return View::make('user/carregamento');
	}

	public function carregar()
	{

	}

	public function logout()
	{
		Session::destroy();

		Redirect::toRoute('home/index');
	}
}

?>