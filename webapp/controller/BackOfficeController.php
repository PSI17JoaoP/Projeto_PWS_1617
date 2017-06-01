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
		/*$dados = array();*/
		/*$users = User::all();*/

		$query = "SELECT * FROM users WHERE UPPER(tipo) = 'USER'";

		$users = User::find_by_sql($query);

		return View::make('backoffice/index', ['users' => $users]);
	}

		public function lock()
	{

		return View::make('backoffice/index');
	}

		public function unlock()
	{

		return View::make('backoffice/index');
	}

	public function register()
	{

		return View::make('backoffice/register');
	}

	public function logout()
	{
		Session::destroy();

		Redirect::toRoute('home/index');
	}

	public function criaradmin()
	{
		//buscardados

		//array

		//se for valido

		//

		//função create account do main controllerZ
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
			Redirect::flashToRoute('backoffice/index', ['user' => $user]);
		}
	}

	public function guardaralteracoes(){
		
		/*$count = User::count(User::all());



		var_dump($count);*/
		
		$query = "SELECT * FROM users";

		$result = User::find_by_sql($query);

		$numeroUsers = count($result);

		
		
		for ($i=1; $i <= $numeroUsers ; $i++) { 
			
			@$id = Post::get($i);

			$user = User::find($i);
			
			if (is_null($id)) {
				$user->bloqueado = false;
			} else {
				$user->bloqueado = true;
			}

			if($user->is_valid()) {
				$user->save();
				Redirect::toRoute('backoffice/index');
			}	
		}

		//1. vai buscar o numero de utilizadores count.

		//2. um for de 1 até ao count.
			//2.1 se isset(post::get(i))
				//codigobloquear 
			//2.2 else
				//codigo desbloquear
	}

	



}

?>