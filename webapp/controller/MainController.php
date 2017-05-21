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

		$dados = array('nome_completo' => $nome, 'data_nascimento' => $birthdate, 'email' => $email, 'username' => $username, 'password' => password_hash($password, PASSWORD_BCRYPT), 'tipo' => "User", 'saldo_atual' => 0, 'bloqueado' => false);

		$user = new User($dados);

		if($user->is_valid())
		{
			$user->save();

			Redirect::ToRoute('home/index');
		}

		else
		{
			Redirect::flashToRoute('home/index', ['user' => $user]);
		}
	}

	public function login()
	{
		$username = Post::get('username');
		$password = Post::get('password');

		$user = User::find_by_username($username);

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

		/*else
		{
			Redirect::flashToRoute('home/index', ['user' => $user]);
		}*/
	}

	public function jackpot()
	{
		$jackpot = array();


		$query = "SELECT users.nome_completo, COUNT(*), SUM(valor)
					FROM users
					JOIN movements ON users.id = movements.idutilizador
					WHERE movements.tipo = 'win'
					GROUP BY movements.idutilizador
					ORDER BY 3 DESC;";

		//$jackpot = User::find_by_sql($query);



		$con = mysqli_connect("localhost", "root", "", "poker_online");

		$records = mysqli_query($con, $query);

		while($row = mysqli_fetch_array($records))
		{
			$line = array($row[0], $row[1], $row[2]);
			array_push($jackpot, $line);
		}

		mysqli_close($con);

		return View::make('home/jackpot',  ['jackpot' => $jackpot]);
	}
}

?>