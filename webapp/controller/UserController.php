<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;


class UserController extends BaseController
{

	public function index()
	{

		return View::make('user/index');
	}

	public function perfil()
	{

		return View::make('user/index');
	}

	public function editar()
	{
		
	}

	public function movimentos()
	{

		return View::make('user/movimentos');
	}

	public function carregamento()
	{

		return View::make('user/carregar');
	}

	public function carregar()
	{

	}
}

?>