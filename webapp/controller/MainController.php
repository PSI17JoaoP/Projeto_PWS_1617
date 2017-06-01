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
		if(Session::has('user'))
		{
			Redirect::ToRoute('user/perfil');
		}

		elseif (Session::has('admin'))
		{
			Redirect::toRoute('backoffice/index');
		}

		else
		{
			return View::make('home/login');
		}
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

		if(!is_null($nome) && !is_null($birthdate) && !is_null($email) && !is_null($username) && !is_null($password))
		{
			$dados = array('nome_completo' => $nome, 'data_nascimento' => $birthdate, 'email' => $email, 'username' => $username, 'password' => password_hash($password, PASSWORD_BCRYPT), 'tipo' => "User", 'saldo_atual' => 0, 'bloqueado' => false);

			$user = new User($dados);

			if($user->is_valid())
			{
				$user->save();

				Redirect::ToRoute('home/index');
			}

			/*else
			{
				Redirect::flashToRoute('home/index', ['user' => $user->errors]);
			}*/
		}
	}

	public function login()
	{
		$username = Post::get('username');
		$password = Post::get('password');

		if(!is_null($username) && !is_null($password))
		{
			$user = User::find_by_username($username);

			if(!is_null($user))
			{
				if(password_verify($password, $user->password))
				{
					if($user->tipo === "Admin")
					{
						Session::set('admin', $user);

						Redirect::toRoute('backoffice/index', $user->id);
					}

					else
					{
						Session::set('user', $user);

						Redirect::toRoute('game/index', $user->id);
					}
				}
			}
		}
	}

	public function jackpot()
	{
		$jackpot = array();

		$query = "SELECT users.nome_completo, COUNT(*) as 'Count', SUM(valor) as 'Sum'
					FROM users
					JOIN movements ON users.id = movements.idutilizador
					WHERE movements.tipo = 'win'
					GROUP BY movements.idutilizador
					ORDER BY 3 DESC
					LIMIt 10;";

		
		$results = User::find_by_sql($query);

		foreach ($results as $i => $record) {
			$line = array($record->nome_completo, $record->count, $record->sum);
			array_push($jackpot, $line);
		}

		return View::make('home/jackpot',  ['jackpot' => $jackpot]);
	}
}

?>