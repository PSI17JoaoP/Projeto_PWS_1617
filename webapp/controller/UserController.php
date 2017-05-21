<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;


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

		//$user = User::find($id);

		$user = Session::get('user');

		if(is_null($password))
		{
			$dados = array('nome_completo' => $nome, 'data_nascimento' => $birthdate, 'email' => $email, 'username' => $username);
		}

		else
		{
			$dados = array('nome_completo' => $nome, 'data_nascimento' => $birthdate, 'email' => $email, 'username' => $username,
			'password' => password_hash($password, PASSWORD_BCRYPT));
		}

		if($user->is_valid())
		{
			$user->update_attributes($dados);

			Redirect::ToRoute('user/perfil');
		}
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