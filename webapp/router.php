<?php

use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName@methodActionName
 ****************************************************************************/

//-----------------------HOME----------------------------------

Router::get('/',				'MainController/index');
Router::get('home/',			'MainController/index');
Router::get('home/index',		'MainController/index');
Router::get('home/login',		'MainController/index');
Router::post('home/login',		'MainController/login');
Router::get('home/register',	'MainController/register');
Router::post('home/register',	'MainController/makeaccount');
Router::get('home/jackpot',	    'MainController/jackpot');

//--------------------------------------------------------------

//-----------------------USER-----------------------------------

Router::get('user/', 		                    'UserController/index');
Router::get('user/perfil', 		                'UserController/perfil');
Router::post('user/perfil', 		            'UserController/editar');
Router::get('user/movimentos', 		            'UserController/movimentos');
Router::get('user/carregamento', 		        'UserController/carregamento');
Router::post('user/carregamento', 		        'UserController/carregar');
Router::get('user/logout', 		                'UserController/logout');

//--------------------------------------------------------------

//-----------------------BACKOFFICE-----------------------------

Router::get('backoffice/', 		                'BackOfficeController/index');
Router::get('backoffice/index', 		        'BackOfficeController/index');
Router::get('backoffice/register',   			'BackOfficeController/register');
Router::post('backoffice/register', 			'BackOfficeController/criaradmin');
Router::get('backoffice/logout', 				'BackOfficeController/logout');
Router::post('backoffice/status', 			    'BackOfficeController/guardaralteracoes');


//--------------------------------------------------------------

//----------------------ZONA DE JOGO-----------------------------

Router::get('game/', 			'GameController/index');
Router::get('game/index', 		'GameController/index');
Router::post('game/start', 		'GameController/start');
Router::post('game/finish',		'GameController/finish');

//---------------------------------------------------------------

/************** End of URLEncoder Routing Rules ************************************/