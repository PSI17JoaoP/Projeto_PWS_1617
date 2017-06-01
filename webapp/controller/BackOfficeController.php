<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class BackOfficeController extends BaseController
{

	public function index()
	{
		if(Session::has('admin'))
		{
			$query = "SELECT * FROM users WHERE UPPER(tipo) = 'USER'";

			$users = User::find_by_sql($query);

			return View::make('backoffice/index', ['users' => $users]);
		}

		else
		{
			Redirect::toRoute('home/index');
		}
	}

	public function register()
	{
		if(Session::has('admin'))
		{
			return View::make('backoffice/register');
		}

		else
		{
			Redirect::toRoute('home/index');
		}
	}

	public function logout()
	{
		if(Session::has('admin'))
		{
			Session::destroy();

			Redirect::toRoute('home/index');
		}

		else
		{
			Redirect::toRoute('home/index');
		}
	}

	public function criaradmin()
	{
		$nome = Post::get('nome');
		$birthdate = date_create(Post::get('birthdate'));
		$email = Post::get('email');
		$username = Post::get('username');
		$password = Post::get('password');

		$dados = array('nome_completo' => $nome, 'data_nascimento' => $birthdate, 'email' => $email, 'username' => $username, 'password' => password_hash($password, PASSWORD_BCRYPT), 'tipo' => "Admin", 'saldo_atual' => 0, 'bloqueado' => false);

		$user = new User($dados);

		if($user->is_valid())
		{
			$user->save();

			Redirect::ToRoute('backoffice/index');
		}

		else
		{
			Redirect::flashToRoute('backoffice/index', ['user' => $user->errors]);
		}
	}

	public function guardaralteracoes(){
		
		//1. vai buscar o numero de utilizadores count.

		//2. um for de 1 até ao count.
			//2.1 se isset(post::get(i))
				//codigobloquear 
			//2.2 else
				//codigo desbloquear

		//NÂO FUNCIONA SE OS ID'S NÂO FOREM SEQUÊNCIAIS!
		
		$query = "SELECT * FROM users";

		$result = User::find_by_sql($query);

		$numeroUsers = count($result);

		$all = Post::getAll();

		foreach ($all as $id => $value) {

			$user = User::find($id);

			$user->bloqueado = $value;

			if($user->is_valid()) {
				$user->save();
				Redirect::toRoute('backoffice/index');
			}
		}
	}
}

?>