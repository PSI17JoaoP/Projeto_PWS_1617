<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;


class BackOfficeController extends BaseController
{

	public function index()
	{

		return View::make('backoffice/index');
	}

		public function lock()
	{

		return View::make('backoffice/index');
	}

		public function unlock()
	{

		return View::make('backoffice/index');
	}
}

?>