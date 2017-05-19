<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\URL;
use ArmoredCore\WebObjects\Post;


class MainController extends BaseController
{

	public function index()
	{

		return View::make('home/login');
	}

	public function register()
	{

		return View::make('home/register');
	}

	public function makeaccount()
	{
		$nome = Post::get('nome');
		$birthdate = date_create(Post::get('birthdate'));
		$email = Post::get('email');
		$username = Post::get('username');
		$password = Post::get('password');

		if(!(is_null($nome) || is_null($birthdate) || is_null($email) || is_null($username) || is_null($password)))
		{
			$dados = array('nome_completo' => $nome, 'data_nascimento' => $birthdate, 'email' => $email, 'username' => $username, 'password' => password_hash($password, PASSWORD_BCRYPT), 'tipo' => "User", 'saldo_atual' => 0, 'bloqueado' => false);

			$user = new User($dados);

			/*if($user->is_valid())
			{*/
				$user->save();

				Redirect::ToRoute('home/index');
			/*}*/

			/*else
			{
				Redirect::flashToRoute('home/index', ['user' => $user]);
			}*/
		}
	}

	public function login()
	{
		$username = Post::get('username');
		$password = Post::get('password');

		if(!(is_null($username) || is_null($password)))
		{
			$user = User::find_by_username($username);

			if(password_verify($password, $user->password))
			{
				if($user->tipo === "Admin")
				{
					Redirect::toRoute('backoffice/index', $user->id);
				}

				else
				{
					Redirect::toRoute('game/index', $user->id);
				}
			}

			/*else
			{
				Redirect::flashToRoute('home/index', ['user' => $user]);
			}*/
		}
	}
}

?>